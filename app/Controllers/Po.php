<?php

namespace App\Controllers;

use App\Models\Item_Mstr_Model;
use App\Models\Pr_Mstr_Model;
use App\Models\Prd_Detail_Model;
use App\Models\Po_Mstr_Model;
use App\Models\Pod_Detail_Model;
use App\Models\Stock_Mstr_Model;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Po extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->pr_mstr = new Pr_Mstr_Model();
        $this->prd_detail = new Prd_Detail_Model();
        $this->po_mstr = new Po_Mstr_Model();
        $this->pod_detail = new Pod_Detail_Model();
        $this->stock_mstr = new Stock_Mstr_Model();
        $this->item_mstr = new Item_Mstr_Model();

        $this->uuid = service("uuid");
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET PO
    // ===========================================================================
    public function get_po()
    {
        try {
            $this->po_mstr->query("SET lc_time_names = 'id_ID';");
            $this->po_mstr->select("
                *,
                DATE_FORMAT(po_add_date, '%W, %d %M %Y - %H:%i:%s') AS _po_add_date,
                DATE_FORMAT(po_upd_date, '%W, %d %M %Y - %H:%i:%s') AS _po_upd_date
            ");
            $this->po_mstr->join("suplier_mstr", "suplier_mstr.sup_code = po_mstr.po_sup");

            $this->po_mstr->orderBy("po_add_date", 'DESC');
            $data = $this->po_mstr->findAll();

            if ($data) {
                return $this->respond([
                    "success"       => true,
                    "t_message"     => "Berhasil Menyelesaikan Perintah!",
                    "message"       => null,
                    "data"          => $data,
                ], 200);
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Gagal Menyelesaikan Perintah!",
                    "data"          => null,
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    // ===========================================================================
    // GET PO DETAIL
    // ===========================================================================
    public function get_po_detail($po_code = null)
    {
        try {
            $this->pod_detail->join("po_mstr", "po_mstr.po_code = pod_detail.pod_po");
            $this->pod_detail->join("item_mstr", "item_mstr.item_code = pod_detail.pod_item");
            $this->pod_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($po_code != null) {
                $this->pod_detail->where(["pod_po" => $po_code]);
            }

            $data = $this->pod_detail->findAll();

            if ($data) {
                return $this->respond([
                    "success"       => true,
                    "t_message"     => "Berhasil Menyelesaikan Perintah!",
                    "message"       => null,
                    "data"          => $data,
                ], 200);
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Gagal Menyelesaikan Perintah!",
                    "data"          => null,
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    // ===========================================================================
    // INSERT PO
    // ===========================================================================
    public function insert_po()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'pr_code' => 'required',
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $pr_code = $this->request->getPost("pr_code");
                $po_name = $this->request->getPost("po_name");
                $po_desc = $this->request->getPost("po_desc");

                $t = date("y", time());
                $m = date("m", time());
                $d = date("d", time());

                $po_code = "PO-" . $t . $m . $d . "-" . "000" . rand(100, 999);

                $po = new Po_Mstr_Model();
                $pod = new Pod_Detail_Model();

                $po->db->transBegin();
                $pod->db->transBegin();

                try {
                    $this->pr_mstr->where(["pr_create_po" => "Y"]);
                    $pr = $this->pr_mstr->find($pr_code);

                    $status = $po->insert([
                        "po_code" => $po_code,
                        "po_pr" => $pr_code,
                        "po_name" => $po_name,
                        "po_desc" => $po_desc,
                        "po_sup" => $pr['pr_sup'],
                        "po_total" => $pr['pr_total'],
                        "po_add_by" => $_SESSION['session_admin']['user_full_name'],
                    ]);

                    $this->prd_detail->where(["prd_pr" => $pr_code]);
                    $prd_es = $this->prd_detail->findAll();

                    $status_pod = true;

                    foreach ($prd_es as $prd) {
                        $uuid4 = $this->uuid->uuid4();
                        $pod_uuid = $uuid4->toString();

                        $status_temp = $pod->insert([
                            "pod_uuid" => $pod_uuid,
                            "pod_po" => $po_code,
                            "pod_item" => $prd['prd_item'],
                            "pod_desc" => $prd['prd_desc'],
                            "pod_price" => $prd['prd_price'],
                            "pod_qty" => $prd['prd_qty'],
                            "pod_total" => $prd['prd_total'],
                        ]);

                        if (!$status_temp) {
                            $status_pod = false;
                        }
                    }

                    if ($status && $status_pod) {
                        $this->pr_mstr->update($pr_code, [
                            "pr_create_po" => 'F',
                        ]);

                        $po->db->transCommit();
                        $pod->db->transCommit();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => null,
                        ], 200);
                    } else {
                        $po->db->transRollback();
                        $pod->db->transRollback();

                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } catch (\Exception $e) {
                    $po->db->transRollback();
                    $pod->db->transRollback();

                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => $e->getMessage()
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Maaf, Terjadi Kesalahan Pada Saat Validasi!",
                    "data"          => null,
                    "errors"        => $validation->getErrors(),
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    // ===========================================================================
    // CONFIRM PO
    // ===========================================================================
    public function confirm_po()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "po_code" => "required",
                "po_status" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $po_code = $this->request->getPost("po_code");
                $po_status = $this->request->getPost("po_status");

                $status = $this->po_mstr->update($po_code, [
                    "po_status" => $po_status,
                    "po_upd_by" => $_SESSION['session_admin']['user_full_name'],
                ]);

                if ($status) {
                    $temp = $this->po_mstr->where([
                        "po_code" => $po_code,
                    ])->first();

                    $temp_detail = $this->pod_detail->where([
                        "pod_po" => $po_code,
                    ])->findAll();

                    foreach ($temp_detail as $value) {
                        $this->update_stock($value['pod_item'], $value['pod_qty']);
                    }

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Disimpan!",
                        "message"       => null,
                        "data"          => $temp_detail,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Disimpan!",
                        "data"          => null,
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Maaf, Terjadi Kesalahan Pada Saat Validasi!",
                    "data"          => null,
                    "errors"        => $validation->getErrors(),
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    public function update_stock($item_code = null, $qty = null)
    {
        try {
            $check_item = $this->item_mstr->where([
                "item_code" => $item_code,
            ])->first();

            if ($check_item) {
                $status = $this->item_mstr->update($check_item['item_code'], [
                    "item_stock" => $check_item['item_stock'] + $qty,
                ]);

                $uuid4 = $this->uuid->uuid4();
                $stock_uuid = $uuid4->toString();

                $status = $this->stock_mstr->insert([
                    "stock_uuid" => $stock_uuid,
                    "stock_item" => $item_code,
                    "stock_qty" => $qty,
                    "stock_type" => "STOCK IN",
                    "stock_add_by" => $_SESSION['session_admin']['user_full_name'],
                ]);
            }
        } catch (\Throwable $th) {
        } catch (\Exception $e) {
        }
    }
}

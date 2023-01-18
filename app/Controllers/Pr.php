<?php

namespace App\Controllers;

use App\Models\Pr_Mstr_Model;
use App\Models\Prd_Detail_Model;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Pr extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->pr_mstr = new Pr_Mstr_Model();
        $this->prd_detail = new Prd_Detail_Model();

        $this->uuid = service("uuid");
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET PR
    // ===========================================================================
    public function get_pr()
    {
        try {
            $this->pr_mstr->query("SET lc_time_names = 'id_ID';");
            $this->pr_mstr->select("
                *,
                DATE_FORMAT(pr_add_date, '%W, %d %M %Y - %H:%i:%s') AS _pr_add_date,
                DATE_FORMAT(pr_upd_date, '%W, %d %M %Y - %H:%i:%s') AS _pr_upd_date
            ");
            $this->pr_mstr->join("suplier_mstr", "suplier_mstr.sup_code = pr_mstr.pr_sup");
            $this->pr_mstr->orderBy("pr_add_date", 'DESC');
            $data = $this->pr_mstr->findAll();

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
    // GET PR DETAIL
    // ===========================================================================
    public function get_pr_detail($pr_code = null)
    {
        try {
            $this->prd_detail->join("pr_mstr", "pr_mstr.pr_code = prd_detail.prd_pr");
            $this->prd_detail->join("item_mstr", "item_mstr.item_code = prd_detail.prd_item");
            $this->prd_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($pr_code != null) {
                $this->prd_detail->where(["prd_pr" => $pr_code]);
            }

            $data = $this->prd_detail->findAll();

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
    // INSERT PR
    // ===========================================================================
    public function insert_pr()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'pr_name' => 'required',
                'pr_sup' => 'required',
                'pr_total' => 'required',

                'prd_item' => 'required',
                'prd_price' => 'required',
                'prd_qty' => 'required',
                'prd_total' => 'required',
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $pr_name = $this->request->getPost("pr_name");
                $pr_desc = $this->request->getPost("pr_desc");
                $pr_sup = $this->request->getPost("pr_sup");
                $pr_total = $this->request->getPost("pr_total");

                $prd_item = $this->request->getPost("prd_item");
                $prd_desc = $this->request->getPost("prd_desc");
                $prd_price = $this->request->getPost("prd_price");
                $prd_qty = $this->request->getPost("prd_qty");
                $prd_total = $this->request->getPost("prd_total");

                $t = date("y", time());
                $m = date("m", time());
                $d = date("d", time());

                $pr_code = "PR-" . $t . $m . $d . "-" . "000" . rand(100, 999);

                $pr = new Pr_Mstr_Model();
                $prd = new Prd_Detail_Model();

                $pr->db->transBegin();
                $prd->db->transBegin();

                try {
                    $status = $pr->insert([
                        "pr_code" => $pr_code,
                        "pr_name" => $pr_name,
                        "pr_desc" => $pr_desc,
                        "pr_sup" => $pr_sup,
                        "pr_total" => $pr_total,
                        "pr_add_by" => $_SESSION['session_admin']['user_full_name'],
                    ]);

                    $status_prd = true;

                    for ($i = 0; $i < count($prd_item); $i++) {
                        $uuid4 = $this->uuid->uuid4();
                        $prd_uuid = $uuid4->toString();

                        $status_temp = $prd->insert([
                            "prd_uuid" => $prd_uuid,
                            "prd_pr" => $pr_code,
                            "prd_item" => $prd_item[$i],
                            "prd_desc" => $prd_desc[$i],
                            "prd_price" => $prd_price[$i],
                            "prd_qty" => $prd_qty[$i],
                            "prd_total" => $prd_total[$i],
                        ]);

                        if (!$status_temp) {
                            $status_prd = false;
                        }
                    }

                    if ($status && $status_prd) {
                        $pr->db->transCommit();
                        $prd->db->transCommit();

                        $temp = $this->pr_mstr->where([
                            "pr_code" => $pr_code,
                        ])->first();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => $temp,
                        ], 200);
                    } else {
                        $pr->db->transRollback();
                        $prd->db->transRollback();

                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } catch (\Exception $e) {
                    $pr->db->transRollback();
                    $prd->db->transRollback();

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
    // APPROVE PR
    // ===========================================================================
    public function approve_pr()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "pr_code" => "required",
                "pr_approve" => "required",
                // "pr_approve_desc" => "required",
                "pr_create_po" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $pr_code = $this->request->getPost("pr_code");
                $pr_approve = $this->request->getPost("pr_approve");
                $pr_approve_desc = $this->request->getPost("pr_approve_desc");
                $pr_create_po = $this->request->getPost("pr_create_po");

                // $this->pr_mstr->where(["pr_code" => $pr_code]);
                $status = $this->pr_mstr->update($pr_code, [
                    "pr_approve" => $pr_approve,
                    "pr_approve_desc" => $pr_approve_desc,
                    "pr_create_po" => $pr_create_po,
                    "pr_upd_by" => $_SESSION['session_admin']['user_full_name'],
                ]);

                if ($status) {
                    $temp = $this->pr_mstr->where([
                        "pr_code" => $pr_code,
                    ])->first();

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Disimpan!",
                        "message"       => null,
                        "data"          => $temp,
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
}

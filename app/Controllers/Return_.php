<?php

namespace App\Controllers;

use App\Models\Return_Mstr_Model;
use App\Models\Returnd_Detail_Model;
use App\Models\Pod_Detail_Model;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Return_ extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->return_mstr = new Return_Mstr_Model();
        $this->returnd_detail = new Returnd_Detail_Model();
        $this->pod_detail = new Pod_Detail_Model();

        $this->uuid = service("uuid");
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET RETURN
    // ===========================================================================
    public function get_return()
    {
        try {
            $this->return_mstr->query("SET lc_time_names = 'id_ID';");
            $this->return_mstr->select("
                *,
                DATE_FORMAT(return_add_date, '%W, %d %M %Y - %H:%i:%s') AS _return_add_date,
                DATE_FORMAT(return_upd_date, '%W, %d %M %Y - %H:%i:%s') AS _return_upd_date
            ");
            $this->return_mstr->join("po_mstr", "po_mstr.po_code = return_mstr.return_po");
            $this->return_mstr->join("suplier_mstr", "suplier_mstr.sup_code = po_mstr.po_sup");

            $this->return_mstr->orderBy("return_add_date", 'DESC');
            $data = $this->return_mstr->findAll();

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
    // GET RETURN DETAIL
    // ===========================================================================
    public function get_return_detail($return_code = null)
    {
        try {
            $this->returnd_detail->join("return_mstr", "return_mstr.return_code = returnd_detail.returnd_return");
            $this->returnd_detail->join("item_mstr", "item_mstr.item_code = returnd_detail.returnd_item");
            $this->returnd_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($return_code != null) {
                $this->returnd_detail->where(["returnd_return" => $return_code]);
            }

            $data = $this->returnd_detail->findAll();

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
    // GET ITEM 
    // ===========================================================================
    public function get_item()
    {
        try {
            $return_po = $this->request->getJsonVar("return_po");

            $this->pod_detail->join("item_mstr", "item_mstr.item_code = pod_detail.pod_item");
            $this->pod_detail->join("item_group", "item_group.itemg_code = item_mstr.item_group");
            $this->pod_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($return_po != null) {
                $this->pod_detail->where(["pod_po" => $return_po]);
            }

            $this->pod_detail->orderBy('item_name', 'ASC');
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
    // INSERT RETURN
    // ===========================================================================
    public function insert_return()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'return_po' => 'required',
                'return_name' => 'required',

                'returnd_item' => 'required',
                'returnd_reason' => 'required',
                'returnd_qty' => 'required',
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $return_po = $this->request->getPost("return_po");
                $return_name = $this->request->getPost("return_name");
                $return_desc = $this->request->getPost("return_desc");

                $returnd_item = $this->request->getPost("returnd_item");
                $returnd_reason = $this->request->getPost("returnd_reason");
                $returnd_qty = $this->request->getPost("returnd_qty");

                $t = date("y", time());
                $m = date("m", time());
                $d = date("d", time());

                $return_code = "RTN-" . $t . $m . $d . "-" . "000" . rand(100, 999);

                $return = new Return_Mstr_Model();
                $returnd = new Returnd_Detail_Model();

                $return->db->transBegin();
                $returnd->db->transBegin();

                try {
                    $status = $return->insert([
                        "return_code" => $return_code,
                        "return_po" => $return_po,
                        "return_name" => $return_name,
                        "return_desc" => $return_desc,
                        "return_add_by" => $_SESSION['session_admin']['user_full_name'],
                    ]);

                    $status_returnd = true;

                    for ($i = 0; $i < count($returnd_item); $i++) {
                        $uuid4 = $this->uuid->uuid4();
                        $returnd_uuid = $uuid4->toString();

                        $status_temp = $returnd->insert([
                            "returnd_uuid" => $returnd_uuid,
                            "returnd_return" => $return_code,
                            "returnd_item" => $returnd_item[$i],
                            "returnd_reason" => $returnd_reason[$i],
                            "returnd_qty" => $returnd_qty[$i],
                        ]);

                        if (!$status_temp) {
                            $status_returnd = false;
                        }
                    }

                    if ($status && $status_returnd) {
                        $return->db->transCommit();
                        $returnd->db->transCommit();

                        $temp = $this->return_mstr->where([
                            "return_code" => $return_code,
                        ])->first();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => $temp,
                        ], 200);
                    } else {
                        $return->db->transRollback();
                        $returnd->db->transRollback();

                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } catch (\Exception $e) {
                    $return->db->transRollback();
                    $returnd->db->transRollback();

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
    // CONFIRM RETURN
    // ===========================================================================
    public function confirm_return()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "return_code" => "required",
                "return_status" => "required",
                "return_bukti_penerimaan" => [
                    "rules" => "uploaded[return_bukti_penerimaan]|mime_in[return_bukti_penerimaan,image/jpg,image/jpeg,image/png]|max_size[return_bukti_penerimaan,4096]",
                    "errors" => [
                        "uploaded" => "The return_bukti_penerimaan field is required.",
                        "mime_in" => "File Extention Harus Berupa jpg, jpeg, png",
                        "max_size" => "Ukuran File Maksimal 4 MB"
                    ]
                ]
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $return_code = $this->request->getPost("return_code");
                $return_status = $this->request->getPost("return_status");
                $return_bukti_penerimaan = $this->request->getFile("return_bukti_penerimaan");
                $fileName = $return_bukti_penerimaan->getRandomName();

                $status = $this->return_mstr->update($return_code, [
                    "return_bukti_penerimaan" => $fileName,
                    "return_status" => $return_status,
                ]);

                if ($status) {
                    $return_bukti_penerimaan->move("_img/return/", $fileName);

                    $temp = $this->return_mstr->where([
                        "return_code" => $return_code,
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


    // ===========================================================================
    // ADD ITEM
    // ===========================================================================
    public function add_item()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "pod_po" => "required",
                "pod_item" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $pod_po = $this->request->getPost("pod_po");
                $pod_item = $this->request->getPost("pod_item");

                $this->pod_detail->join("item_mstr", "item_mstr.item_code = pod_detail.pod_item");
                $this->pod_detail->join("item_group", "item_group.itemg_code = item_mstr.item_group");
                $this->pod_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");
                $this->pod_detail->where("pod_po", $pod_po);
                $this->pod_detail->where("pod_item", $pod_item);
                $checking_item = $this->pod_detail->find();

                if ($checking_item) {
                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Successfully Completed!",
                        "message"       => null,
                        "data"          => $checking_item[0],
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Failed to complete!",
                        "data"          => null,
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Terjadi Kesalahan Pada Saat Validasi!",
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

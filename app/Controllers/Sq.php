<?php

namespace App\Controllers;

use App\Models\Sq_Mstr_Model;
use App\Models\Sqd_Detail_Model;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Sq extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->sq_mstr = new Sq_Mstr_Model();
        $this->sqd_detail = new Sqd_Detail_Model();

        $this->uuid = service("uuid");
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET SQ
    // ===========================================================================
    public function get_sq()
    {
        try {
            $this->sq_mstr->query("SET lc_time_names = 'id_ID';");
            $this->sq_mstr->select("
                *,
                DATE_FORMAT(sq_add_date, '%W, %d %M %Y - %H:%i:%s') AS _sq_add_date,
                DATE_FORMAT(sq_upd_date, '%W, %d %M %Y - %H:%i:%s') AS _sq_upd_date
            ");
            $this->sq_mstr->join("user_mstr", "user_mstr.user_id = sq_mstr.sq_user");
            $this->sq_mstr->orderBy("sq_add_date", 'DESC');
            $data = $this->sq_mstr->findAll();

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
    // GET SQ DETAIL
    // ===========================================================================
    public function get_sq_detail($sq_code = null)
    {
        try {
            $this->sqd_detail->join("sq_mstr", "sq_mstr.sq_code = sqd_detail.sqd_sq");
            $this->sqd_detail->join("item_mstr", "item_mstr.item_code = sqd_detail.sqd_item");
            $this->sqd_detail->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($sq_code != null) {
                $this->sqd_detail->where(["sqd_sq" => $sq_code]);
            }

            $data = $this->sqd_detail->findAll();

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
    // INSERT SQ
    // ===========================================================================
    public function insert_sq()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'sq_cash_status' => 'required',
                'sq_total' => 'required',

                'sqd_item' => 'required',
                'sqd_price' => 'required',
                'sqd_qty' => 'required',
                'sqd_total' => 'required',
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $sq_desc = $this->request->getPost("sq_desc");
                $sq_cash_status = $this->request->getPost("sq_cash_status");
                $sq_total = $this->request->getPost("sq_total");

                $sqd_item = $this->request->getPost("sqd_item");
                $sqd_desc = $this->request->getPost("sqd_desc");
                $sqd_price = $this->request->getPost("sqd_price");
                $sqd_qty = $this->request->getPost("sqd_qty");
                $sqd_total = $this->request->getPost("sqd_total");

                $t = date("y", time());
                $m = date("m", time());
                $d = date("d", time());

                $sq_code = "SQ-" . $t . $m . $d . "-" . "000" . rand(100, 999);

                $sq = new Sq_Mstr_Model();
                $sqd = new Sqd_Detail_Model();

                $sq->db->transBegin();
                $sqd->db->transBegin();

                try {
                    $status = $sq->insert([
                        "sq_code" => $sq_code,
                        "sq_desc" => $sq_desc,
                        "sq_user" => $_SESSION['session_admin']['user_id'],
                        "sq_cash_status" => $sq_cash_status,
                        "sq_total" => $sq_total,
                        "sq_add_by" => $_SESSION['session_admin']['user_full_name'],
                    ]);

                    $status_sqd = true;

                    for ($i = 0; $i < count($sqd_item); $i++) {
                        $uuid4 = $this->uuid->uuid4();
                        $sqd_uuid = $uuid4->toString();

                        $status_temp = $sqd->insert([
                            "sqd_uuid" => $sqd_uuid,
                            "sqd_sq" => $sq_code,
                            "sqd_desc" => $sqd_desc[$i],
                            "sqd_item" => $sqd_item[$i],
                            "sqd_price" => $sqd_price[$i],
                            "sqd_qty" => $sqd_qty[$i],
                            "sqd_total" => $sqd_total[$i],
                        ]);

                        if (!$status_temp) {
                            $status_sqd = false;
                        }
                    }

                    if ($status && $status_sqd) {
                        $sq->db->transCommit();
                        $sqd->db->transCommit();

                        $temp = $this->sq_mstr->where([
                            "sq_code" => $sq_code,
                        ])->first();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => $temp,
                        ], 200);
                    } else {
                        $sq->db->transRollback();
                        $sqd->db->transRollback();

                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } catch (\Exception $e) {
                    $sq->db->transRollback();
                    $sqd->db->transRollback();

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
}

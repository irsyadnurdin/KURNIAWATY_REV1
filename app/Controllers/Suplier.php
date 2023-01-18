<?php

namespace App\Controllers;

use App\Models\Suplier_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Suplier extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->suplier_mstr = new Suplier_Mstr_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET SUPLIER
    // ===========================================================================
    public function get_suplier($active = "Y")
    {
        try {
            if ($active != "all") {
                $this->suplier_mstr->where(["sup_active" => $active]);
            }

            $this->suplier_mstr->orderBy('sup_name', 'ASC');
            $data = $this->suplier_mstr->findAll();

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
    // INSERT SUPLIER
    // ===========================================================================
    public function insert_suplier()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "sup_code" => "required",
                "sup_name" => "required",
                "sup_address" => "required",
                "sup_phone" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $sup_code = $this->request->getPost("sup_code");
                $sup_name = $this->request->getPost("sup_name");
                $sup_desc = $this->request->getPost("sup_desc");
                $sup_address = $this->request->getPost("sup_address");
                $sup_phone = $this->request->getPost("sup_phone");

                $checking_duplication = $this->suplier_mstr->where([
                    "sup_code" => $sup_code,
                ])->first();

                if (!$checking_duplication) {
                    $status = $this->suplier_mstr->insert([
                        "sup_code" => $sup_code,
                        "sup_name" => $sup_name,
                        "sup_desc" => $sup_desc,
                        "sup_address" => $sup_address,
                        "sup_phone" => $sup_phone,
                    ]);

                    if ($status) {
                        $temp = $this->suplier_mstr->where([
                            "sup_code" => $sup_code,
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
                        "message"       => "Maaf, Data Gagal Disimpan Karena Terjadi Duplikasi!",
                        "data"          => $checking_duplication,
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
    // UPDATE SUPLIER
    // ===========================================================================
    public function update_suplier()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "sup_code" => "required",
                "sup_name" => "required",
                "sup_address" => "required",
                "sup_phone" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $sup_code = $this->request->getPost("sup_code");
                $sup_name = $this->request->getPost("sup_name");
                $sup_desc = $this->request->getPost("sup_desc");
                $sup_address = $this->request->getPost("sup_address");
                $sup_phone = $this->request->getPost("sup_phone");
                $sup_active = $this->request->getPost("sup_active");

                if ($sup_active != null) {
                    $this->suplier_mstr->set("sup_active", $sup_active);
                }

                $status = $this->suplier_mstr->update($sup_code, [
                    "sup_name" => $sup_name,
                    "sup_desc" => $sup_desc,
                    "sup_address" => $sup_address,
                    "sup_phone" => $sup_phone,
                ]);

                if ($status) {
                    $temp = $this->suplier_mstr->where([
                        "sup_code" => $sup_code,
                    ])->first();

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Diperbaharui!",
                        "message"       => null,
                        "data"          => $temp,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Diperbaharui!",
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

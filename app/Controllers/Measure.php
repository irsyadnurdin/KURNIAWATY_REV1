<?php

namespace App\Controllers;

use App\Models\Measure_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Measure extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->measure_mstr = new Measure_Mstr_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET MEASURE
    // ===========================================================================
    public function get_measure()
    {
        try {
            $this->measure_mstr->orderBy('measure_code', 'ASC');
            $data = $this->measure_mstr->findAll();

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
    // INSERT MEASURE
    // ===========================================================================
    public function insert_measure()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "measure_code" => "required",
                "measure_name" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $measure_code = $this->request->getPost("measure_code");
                $measure_name = $this->request->getPost("measure_name");

                $checking_duplication = $this->measure_mstr->where([
                    "measure_code" => $measure_code,
                ])->first();

                if (!$checking_duplication) {
                    $status = $this->measure_mstr->insert([
                        "measure_code" => $measure_code,
                        "measure_name" => $measure_name,
                    ]);

                    if ($status) {
                        $temp = $this->measure_mstr->where([
                            "measure_code" => $measure_code,
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
                "measure_code" => "required",
                "measure_name" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $measure_code = $this->request->getPost("measure_code");
                $measure_name = $this->request->getPost("measure_name");

                $status = $this->suplier_mstr->update($measure_code, [
                    "measure_name" => $measure_name,
                ]);

                if ($status) {
                    $temp = $this->suplier_mstr->where([
                        "measure_code" => $measure_code,
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

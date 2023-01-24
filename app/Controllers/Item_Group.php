<?php

namespace App\Controllers;

use App\Models\Item_Group_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Item_Group extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->item_group = new Item_Group_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET ITEM GROUP
    // ===========================================================================
    public function get_item_group()
    {
        try {
            $this->item_group->where(["itemg_code !=" => "ITMG-BAHANBAKU"]);
            $this->item_group->orderBy('itemg_code', 'ASC');
            $data = $this->item_group->findAll();

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
    // INSERT ITEM GROUP
    // ===========================================================================
    public function insert_item_group()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "itemg_code" => "required",
                "itemg_name" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $itemg_code = $this->request->getPost("itemg_code");
                $itemg_name = $this->request->getPost("itemg_name");

                $cek_duplikasi = $this->item_group->where([
                    "itemg_code" => $itemg_code,
                ])->first();

                if (!$cek_duplikasi) {
                    $status = $this->item_group->insert([
                        "itemg_code" => $itemg_code,
                        "itemg_name" => $itemg_name,
                    ]);

                    if ($status) {
                        $temp = $this->item_group->where([
                            "itemg_code" => $itemg_code,
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
                        "data"          => $cek_duplikasi,
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
    // UPDATE ITEM GROUP
    // ===========================================================================
    public function update_item_group()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "itemg_code" => "required",
                "itemg_name" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $itemg_code = $this->request->getPost("itemg_code");
                $itemg_name = $this->request->getPost("itemg_name");

                $status = $this->item_group->update($itemg_code, [
                    "itemg_name" => $itemg_name,
                ]);

                if ($status) {
                    $temp = $this->item_group->where([
                        "itemg_code" => $itemg_code,
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


    // ===========================================================================
    // DELETE ITEM GROUP
    // ===========================================================================
    public function delete_item_group()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "itemg_code" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $itemg_code = $this->request->getPost("itemg_code");

                $status = $this->item_group->delete($itemg_code);

                if ($status) {
                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Dihapus!",
                        "message"       => null,
                        "data"          => null,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Dihapus!",
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

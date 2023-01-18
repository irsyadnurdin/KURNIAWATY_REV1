<?php

namespace App\Controllers;

use App\Models\Item_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Item extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->item_mstr = new Item_Mstr_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET ITEM 
    // ===========================================================================
    public function get_item($active = "Y")
    {
        try {
            $ps_item = $this->request->getJsonVar("ps_item");
            $item_type = $this->request->getJsonVar("item_type");

            $this->item_mstr->join("item_group", "item_group.itemg_code = item_mstr.item_group");
            $this->item_mstr->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($ps_item != null) {
                $this->item_mstr->where(["item_code !=" => $ps_item]);
            }

            if ($item_type != null) {
                $this->item_mstr->wherein("item_type", $item_type);
            }

            if ($active != "all") {
                $this->item_mstr->where(["item_active" => $active]);
            }

            $this->item_mstr->orderBy('item_type ASC, item_group ASC, item_name ASC');
            $data = $this->item_mstr->findAll();

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
    // INSERT ITEM
    // ===========================================================================
    public function insert_item()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
                "item_name" => "required",
                "item_group" => "required",
                "item_type" => "required",
                "item_measure" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");
                $item_name = $this->request->getPost("item_name");
                $item_desc = $this->request->getPost("item_desc");
                $item_group = $this->request->getPost("item_group");
                $item_type = $this->request->getPost("item_type");
                $item_measure = $this->request->getPost("item_measure");

                $checking_duplication = $this->item_mstr->where([
                    "item_code" => $item_code,
                ])->first();

                if (!$checking_duplication) {
                    $status = $this->item_mstr->insert([
                        "item_code" => $item_code,
                        "item_name" => $item_name,
                        "item_desc" => $item_desc,
                        "item_group" => $item_group,
                        "item_type" => $item_type,
                        "item_measure" => $item_measure,
                    ]);

                    if ($status) {
                        $temp = $this->item_mstr->where([
                            "item_code" => $item_code,
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
    // UPDATE ITEM
    // ===========================================================================
    public function update_item()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
                "item_name" => "required",
                "item_group" => "required",
                "item_type" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");
                $item_name = $this->request->getPost("item_name");
                $item_desc = $this->request->getPost("item_desc");
                $item_group = $this->request->getPost("item_group");
                $item_type = $this->request->getPost("item_type");

                $status = $this->item_mstr->update($item_code, [
                    "item_name" => $item_name,
                    "item_desc" => $item_desc,
                    "item_group" => $item_group,
                    "item_type" => $item_type,
                ]);

                if ($status) {
                    $temp = $this->item_mstr->where([
                        "item_code" => $item_code,
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
    // UPDATE PRICELIST ITEM
    // ===========================================================================
    public function update_pricelist_item()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
                "item_price" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");
                $item_price = $this->request->getPost("item_price");

                $status = $this->item_mstr->update($item_code, [
                    "item_price" => $item_price,
                ]);

                if ($status) {
                    $temp = $this->item_mstr->where([
                        "item_code" => $item_code,
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
    // UPDATE ACTIVE
    // ===========================================================================
    public function update_active()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
                "item_active" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");
                $item_active = $this->request->getPost("item_active");

                $status = $this->item_mstr->update($item_code, [
                    "item_active" => $item_active,
                ]);

                if ($status) {
                    $temp = $this->item_mstr->where([
                        "item_code" => $item_code,
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
    // UPDATE IMAGE
    // ===========================================================================
    public function update_item_image()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
                "item_image" => [
                    "rules" => "uploaded[item_image]|mime_in[item_image,image/jpg,image/jpeg,image/png]|max_size[item_image,4096]",
                    "errors" => [
                        "uploaded" => "The item_image field is required.",
                        "mime_in" => "File Extention Harus Berupa jpg, jpeg, png",
                        "max_size" => "Ukuran File Maksimal 4 MB"
                    ]
                ]
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");
                $item_image = $this->request->getFile("item_image");
                $fileName = $item_image->getRandomName();

                $temp = $this->item_mstr->find($item_code);

                $status = $this->item_mstr->update($item_code, [
                    "item_image" => $fileName,
                ]);

                if ($status) {
                    if ($temp["item_image"] != "default.png") {
                        $path = "../public/_img/item/";
                        @unlink($path . $temp["item_image"]);
                    }

                    $item_image->move("_img/item/", $fileName);

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Diperbaharui!",
                        "message"       => null,
                        "data"          => null
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
    // ADD ITEM
    // ===========================================================================
    public function add_item()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "item_code" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $item_code = $this->request->getPost("item_code");

                $this->item_mstr->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");
                $checking_item = $this->item_mstr->find($item_code);

                if ($checking_item) {
                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Successfully Completed!",
                        "message"       => null,
                        "data"          => $checking_item,
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

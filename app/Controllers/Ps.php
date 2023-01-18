<?php

namespace App\Controllers;

use App\Models\Ps_Mstr_Model;
use App\Models\Item_Mstr_Model;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Ps extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->ps_mstr = new Ps_Mstr_Model();
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
    // GET PS
    // ===========================================================================
    public function get_ps()
    {
        try {
            $this->ps_mstr->query("SET lc_time_names = 'id_ID';");
            $this->ps_mstr->join("item_mstr", "item_mstr.item_code = ps_mstr.ps_item");
            $this->ps_mstr->groupBy("ps_item");
            $this->ps_mstr->orderBy("item_name", 'ASC');
            $data = $this->ps_mstr->findAll();

            if ($data) {
                return $this->respond([
                    "success"       => true,
                    "t_message"     => "Successfully completed",
                    "message"       => null,
                    "data"          => $data,
                ], 200);
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Failed to complete!",
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
    // GET PS DETAIL
    // ===========================================================================
    public function get_ps_detail($item_code = null)
    {
        try {
            $this->ps_mstr->join("item_mstr", "item_mstr.item_code = ps_mstr.ps_child_item");
            $this->ps_mstr->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");

            if ($item_code != null) {
                $this->ps_mstr->where(["ps_item" => $item_code]);
            }

            $this->ps_mstr->groupBy("ps_child_item");
            $this->ps_mstr->orderBy("item_name", 'ASC');
            $data = $this->ps_mstr->findAll();

            if ($data) {
                return $this->respond([
                    "success"       => true,
                    "t_message"     => "Successfully completed",
                    "message"       => null,
                    "data"          => $data,
                ], 200);
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Failed to complete!",
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


    // ===========================================================================
    // INSERT PS
    // ===========================================================================
    public function insert_ps()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'ps_item' => 'required',
                'ps_child_item' => 'required',
                'ps_qty' => 'required',
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $ps_item = $this->request->getPost("ps_item");
                $ps_child_item = $this->request->getPost("ps_child_item");
                $ps_qty = $this->request->getPost("ps_qty");

                $ps = new Ps_Mstr_Model();

                $ps->db->transBegin();

                try {
                    $status_ps = true;

                    for ($i = 0; $i < count($ps_child_item); $i++) {
                        $uuid4 = $this->uuid->uuid4();
                        $ps_uuid = $uuid4->toString();

                        $status_temp = $ps->insert([
                            "ps_uuid" => $ps_uuid,
                            "ps_item" => $ps_item,
                            "ps_child_item" => $ps_child_item[$i],
                            "ps_qty" => $ps_qty[$i],
                        ]);

                        if (!$status_temp) {
                            $status_ps = false;
                        }
                    }

                    if ($status_ps) {
                        $ps->db->transCommit();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => null,
                        ], 200);
                    } else {
                        $ps->db->transRollback();

                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } catch (\Exception $e) {
                    $ps->db->transRollback();

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
    // DELETE ITEM GROUP
    // ===========================================================================
    public function delete_ps()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "ps_item" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $ps_item = $this->request->getPost("ps_item");

                $this->ps_mstr->where(["ps_item" => $ps_item]);
                $status = $this->ps_mstr->delete();

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

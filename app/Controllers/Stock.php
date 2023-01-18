<?php

namespace App\Controllers;

use App\Models\Stock_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class Stock extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->stock_mstr = new Stock_Mstr_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET STOCK
    // ===========================================================================
    public function get_stock()
    {
        try {
            $this->stock_mstr->join("item_mstr", "item_mstr.item_code = stock_mstr.stock_item");
            // $this->stock_mstr->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");
            $this->stock_mstr->orderBy('stock_add_date', 'DESC');
            $data = $this->stock_mstr->findAll();

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
}

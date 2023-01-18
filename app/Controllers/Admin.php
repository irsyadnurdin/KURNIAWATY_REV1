<?php

namespace App\Controllers;

use App\Models\Setting_Mstr_Model;
use App\Models\User_Mstr_Model;
use App\Models\Pr_Mstr_Model;
use App\Models\Prd_Detail_Model;
use App\Models\Po_Mstr_Model;
use App\Models\Pod_Mstr_Model;
use App\Models\Suplier_Mstr_Model;
use App\Models\Ps_Mstr_Model;
use App\Models\Item_Mstr_Model;
use App\Models\Item_Group_Model;
use App\Models\Measure_Mstr_Model;
use App\Models\Pod_Detail_Model;
use TCPDF;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;


class Admin extends ResourceController
{
    public function __construct()
    {
        session();

        $this->setting_mstr = new Setting_Mstr_Model();
        $this->user_mstr = new User_Mstr_Model();
        $this->pr_mstr = new Pr_Mstr_Model();
        $this->prd_detail = new Prd_Detail_Model();
        $this->po_mstr = new Po_Mstr_Model();
        $this->pod_detail = new Pod_Detail_Model();
        $this->suplier_mstr = new Suplier_Mstr_Model();
        $this->ps_mstr = new Ps_Mstr_Model();
        $this->item_mstr = new Item_Mstr_Model();
        $this->item_group = new Item_Group_Model();
        $this->measure_mstr = new Measure_Mstr_Model();
        // $this->language = \Config\Services::language();
        // $this->language->setLocale(WEB_LANG);
    }


    // ===========================================================================
    // REQUIRED DATA
    // ===========================================================================
    public function required()
    {
        $data["setting_mstr"] = $this->setting_mstr->findAll();

        $this->user_mstr->join('role_mstr', 'role_mstr.role_code = user_mstr.user_role');
        $data["user_mstr"] = $this->user_mstr->find($_SESSION['session_admin']['user_id']);

        $data['locale'] = $this->request->getLocale();
        $data['supportedLocales'] = $this->request->config->supportedLocales;

        return $data;
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
        $data = $this->required();

        return view('admin/index', $data);
    }


    // ===========================================================================
    // ITEM
    // ===========================================================================
    public function item()
    {
        $data = $this->required();

        $data["measure_es"] = $this->measure_mstr->findAll();
        // $this->item_group->where(["itemg_code !=" => "ITMG-DEFAULT"]);
        $data["item_group_es"] = $this->item_group->findAll();

        return view('admin/item', $data);
    }

    public function item_group()
    {
        $data = $this->required();

        return view('admin/item_group', $data);
    }

    public function measure()
    {
        $data = $this->required();

        return view('admin/measure', $data);
    }


    // ===========================================================================
    // PRICELIST
    // ===========================================================================
    public function pricelist()
    {
        $data = $this->required();

        return view('admin/pricelist', $data);
    }


    // ===========================================================================
    // STOCK
    // ===========================================================================
    public function stock()
    {
        $data = $this->required();

        return view('admin/stock', $data);
    }


    // ===========================================================================
    // SALES QUOTATION
    // ===========================================================================
    public function sq()
    {
        $data = $this->required();

        return view('admin/sq', $data);
    }

    public function sq_add()
    {
        $data = $this->required();
        // $data['pr_code'] = $pr_code;

        // $this->pr_mstr->join("suplier_mstr", "suplier_mstr.sup_code = pr_mstr.pr_sup");
        // $this->pr_mstr->where(["pr_create_po" => "Y"]);
        // $data["pr"] = $this->pr_mstr->find($pr_code);

        // $this->prd_detail->join("item_mstr", "item_mstr.item_code = prd_detail.prd_item");
        // $this->prd_detail->where(["prd_pr" => $pr_code]);
        // $data["prd_es"] = $this->prd_detail->findAll();

        return view('admin/sq_add', $data);
    }


    // ===========================================================================
    // PURCHASE REQUISITION
    // ===========================================================================
    public function pr()
    {
        $data = $this->required();

        return view('admin/pr', $data);
    }

    public function pr_add()
    {
        $data = $this->required();

        $this->suplier_mstr->where(["sup_active" => "Y"]);
        $data["sup_es"] = $this->suplier_mstr->findAll();

        return view('admin/pr_add', $data);
    }


    // ===========================================================================
    // PURCHASE ORDER
    // ===========================================================================
    public function po()
    {
        $data = $this->required();

        return view('admin/po', $data);
    }

    public function po_add($pr_code = null)
    {
        if ($pr_code) {
            $this->pr_mstr->where(["pr_create_po" => "Y"]);
            $data = $this->pr_mstr->find($pr_code);

            if ($data) {
                $data = $this->required();
                $data['pr_code'] = $pr_code;

                $this->pr_mstr->join("suplier_mstr", "suplier_mstr.sup_code = pr_mstr.pr_sup");
                $this->pr_mstr->where(["pr_create_po" => "Y"]);
                $data["pr"] = $this->pr_mstr->find($pr_code);

                $this->prd_detail->join("item_mstr", "item_mstr.item_code = prd_detail.prd_item");
                $this->prd_detail->where(["prd_pr" => $pr_code]);
                $data["prd_es"] = $this->prd_detail->findAll();

                return view('admin/po_add', $data);
            } else {
                return redirect()->to('/admin/po');
            }
        } else {
            return redirect()->to('/admin/po');
        }
    }

    public function po_invoice($po_code = null)
    {
        if ($po_code) {
            $this->po_mstr->where(["po_code" => $po_code]);
            $this->po_mstr->where(["po_status" => "F"]);
            $data = $this->po_mstr->first();

            if ($data) {
                $data = $this->required();
                // $data['pr_code'] = $pr_code;

                $this->po_mstr->select("
                    *,
                    DATE_FORMAT(po_add_date, '%d/%m/%y') AS _po_add_date,
                    DATE_FORMAT(po_upd_date, '%W, %d %M %Y - %H:%i:%s') AS _po_upd_date
                ");
                $this->po_mstr->join("suplier_mstr", "suplier_mstr.sup_code = po_mstr.po_sup");
                $this->po_mstr->where(["po_status" => "F"]);
                $data["po"] = $this->po_mstr->find($po_code);

                $this->pod_detail->join("item_mstr", "item_mstr.item_code = pod_detail.pod_item");
                $this->pod_detail->where(["pod_po" => $po_code]);
                $data["pod_es"] = $this->pod_detail->findAll();

                $writer = new PngWriter();

                // Create QR code
                $qrCode = QrCode::create(base_url('admin/po_invoice/' . $po_code))
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(300)
                    ->setMargin(10)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));

                // Create generic logo
                $logo = Logo::create(FCPATH . 'temp_admin/assets/images/logo-inverse.png')
                    ->setResizeToWidth(200);

                // Create generic label
                $label = Label::create('Kurt Beans Coffee')
                    ->setTextColor(new Color(0, 0, 0));

                $result = $writer->write($qrCode, $logo, $label);

                $data["qr_code"] = $result->getDataUri();

                return view('admin/invoice_po', $data);
            } else {
                return redirect()->to('/admin/po');
            }
        } else {
            return redirect()->to('/admin/po');
        }
    }


    // ===========================================================================
    // RETURN
    // ===========================================================================
    public function return()
    {
        $data = $this->required();

        return view('admin/return', $data);
    }

    public function return_add()
    {
        $data = $this->required();

        // $item = [];
        // $this->ps_mstr->groupBy('ps_item');
        // $temp = $this->ps_mstr->findAll();

        // foreach ($temp as $value) {
        //     array_push($item, $value['ps_item']);
        // }

        // $this->item_mstr->join("item_group", "item_group.itemg_code = item_mstr.item_group");
        $this->po_mstr->join("return_mstr", "return_mstr.return_po = po_mstr.po_code", "LEFT");
        $this->po_mstr->where(["po_status" => "F"]);
        $this->po_mstr->where(["return_code" => null]);
        // if (count($item) != 0) {
        //     $this->item_mstr->whereNotIn('item_code', $item);
        // }
        $this->po_mstr->orderBy('po_add_date', 'DESC');
        $data["po_es"] = $this->po_mstr->findAll();

        return view('admin/return_add', $data);
    }


    // ===========================================================================
    // PRODUCT STRUCTURE
    // ===========================================================================
    public function ps()
    {
        $data = $this->required();

        return view('admin/ps', $data);
    }

    public function ps_add()
    {
        $data = $this->required();

        $item = [];
        $this->ps_mstr->groupBy('ps_item');
        $temp = $this->ps_mstr->findAll();

        foreach ($temp as $value) {
            array_push($item, $value['ps_item']);
        }

        $this->item_mstr->join("item_group", "item_group.itemg_code = item_mstr.item_group");
        $this->item_mstr->join("measure_mstr", "measure_mstr.measure_code = item_mstr.item_measure");
        $this->item_mstr->where(["item_type !=" => "BL"]);
        $this->item_mstr->where(["item_active" => "Y"]);
        if (count($item) != 0) {
            $this->item_mstr->whereNotIn('item_code', $item);
        }
        $this->item_mstr->orderBy('item_name', 'ASC');
        $data["item_es"] = $this->item_mstr->findAll();

        return view('admin/ps_add', $data);
    }


    // ===========================================================================
    // USER
    // ===========================================================================
    public function warehouse()
    {
        $data = $this->required();
        $data["role"] = "warehouse";
        $data["title"] = "Bagian Gudang";

        return view('admin/user', $data);
    }

    public function cashier()
    {
        $data = $this->required();
        $data["role"] = "cashier";
        $data["title"] = "Kasir";

        return view('admin/user', $data);
    }


    // ===========================================================================
    // SUPLIER
    // ===========================================================================
    public function suplier()
    {
        $data = $this->required();

        return view('admin/suplier', $data);
    }


    // ===========================================================================
    // PROFILE
    // ===========================================================================
    public function profile()
    {
        $data = $this->required();

        return view('admin/profile', $data);
    }


    // ===========================================================================
    // LOGOUT
    // ===========================================================================
    public function logout()
    {
        unset($_SESSION['session_admin']);
        return redirect()->to('/login');
    }
}

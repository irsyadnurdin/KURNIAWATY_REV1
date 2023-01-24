<?php

namespace App\Models;

use CodeIgniter\Model;

class Po_Mstr_Model extends Model
{
    protected $table            = 'po_mstr';
    protected $primaryKey       = 'po_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['po_code', 'po_pr', 'po_name', 'po_desc', 'po_sup', 'po_total', 'po_bukti_penerimaan', 'po_status', 'po_add_by', 'po_add_date', 'po_upd_by', 'po_upd_date'];
}

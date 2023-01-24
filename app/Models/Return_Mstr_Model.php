<?php

namespace App\Models;

use CodeIgniter\Model;

class Return_Mstr_Model extends Model
{
    protected $table            = 'return_mstr';
    protected $primaryKey       = 'return_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['return_code', 'return_po', 'return_name', 'return_desc', 'return_bukti_penerimaan', 'return_status', 'return_add_by', 'return_add_date', 'return_upd_by', 'return_upd_date'];
}

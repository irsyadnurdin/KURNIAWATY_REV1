<?php

namespace App\Models;

use CodeIgniter\Model;

class Sq_Mstr_Model extends Model
{
    protected $table            = 'sq_mstr';
    protected $primaryKey       = 'sq_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['sq_code', 'sq_desc', 'sq_user', 'sq_cash_status', 'sq_total', 'sq_add_by', 'sq_add_date', 'sq_upd_by', 'sq_upd_date'];
}

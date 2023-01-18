<?php

namespace App\Models;

use CodeIgniter\Model;

class Suplier_Mstr_Model extends Model
{
    protected $table            = 'suplier_mstr';
    protected $primaryKey       = 'sup_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['sup_code', 'sup_name', 'sup_desc', 'sup_address', 'sup_email', 'sup_phone', 'sup_active'];
}

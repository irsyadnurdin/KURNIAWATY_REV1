<?php

namespace App\Models;

use CodeIgniter\Model;

class Role_Mstr_Model extends Model
{
    protected $table            = 'role_mstr';
    protected $primaryKey       = 'role_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['role_code', 'role_name'];
}

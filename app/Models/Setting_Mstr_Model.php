<?php

namespace App\Models;

use CodeIgniter\Model;

class Setting_Mstr_Model extends Model
{
    protected $table      = 'setting_mstr';
    protected $primaryKey = 'stg_id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['stg_id', 'stg_name', 'stg_value'];
}

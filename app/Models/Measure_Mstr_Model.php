<?php

namespace App\Models;

use CodeIgniter\Model;

class Measure_Mstr_Model extends Model
{
    protected $table            = 'measure_mstr';
    protected $primaryKey       = 'measure_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['measure_code', 'measure_name'];
}

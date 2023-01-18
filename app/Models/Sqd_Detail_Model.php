<?php

namespace App\Models;

use CodeIgniter\Model;

class Sqd_Detail_Model extends Model
{
    protected $table            = 'sqd_detail';
    protected $primaryKey       = 'sqd_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['sqd_uuid', 'sqd_sq', 'sqd_desc', 'sqd_item', 'sqd_price', 'sqd_qty', 'sqd_total'];
}

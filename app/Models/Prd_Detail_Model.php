<?php

namespace App\Models;

use CodeIgniter\Model;

class Prd_Detail_Model extends Model
{
    protected $table            = 'prd_detail';
    protected $primaryKey       = 'prd_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['prd_uuid', 'prd_pr', 'prd_item', 'prd_desc', 'prd_qty', 'prd_price', 'prd_total'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Stock_Mstr_Model extends Model
{
    protected $table            = 'stock_mstr';
    protected $primaryKey       = 'stock_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['stock_uuid', 'stock_item', 'stock_qty', 'stock_measure', 'stock_type', 'stock_add_by', 'stock_add_date'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Item_Mstr_Model extends Model
{
    protected $table            = 'item_mstr';
    protected $primaryKey       = 'item_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['item_code', 'item_name', 'item_desc', 'item_group', 'item_type', 'item_stock', 'item_measure', 'item_price', 'item_image', 'item_active', 'item_add_date', 'item_upd_date'];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class Item_Group_Model extends Model
{
    protected $table            = 'item_group';
    protected $primaryKey       = 'itemg_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['itemg_code', 'itemg_name'];
}

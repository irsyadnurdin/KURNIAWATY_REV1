<?php

namespace App\Models;

use CodeIgniter\Model;

class Returnd_Detail_Model extends Model
{
    protected $table            = 'returnd_detail';
    protected $primaryKey       = 'returnd_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['returnd_uuid', 'returnd_return', 'returnd_item', 'returnd_reason', 'returnd_qty'];
}

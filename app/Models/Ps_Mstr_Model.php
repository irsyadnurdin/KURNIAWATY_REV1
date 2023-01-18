<?php

namespace App\Models;

use CodeIgniter\Model;

class Ps_Mstr_Model extends Model
{
    protected $table            = 'ps_mstr';
    protected $primaryKey       = 'ps_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['ps_uuid', 'ps_item', 'ps_child_item', 'ps_qty'];
}

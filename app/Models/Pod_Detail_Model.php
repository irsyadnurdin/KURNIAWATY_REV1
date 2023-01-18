<?php

namespace App\Models;

use CodeIgniter\Model;

class Pod_Detail_Model extends Model
{
    protected $table            = 'pod_detail';
    protected $primaryKey       = 'pod_uuid';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['pod_uuid', 'pod_po', 'pod_item', 'pod_desc', 'pod_price', 'pod_qty', 'pod_total'];
}

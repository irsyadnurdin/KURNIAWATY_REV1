<?php

namespace App\Models;

use CodeIgniter\Model;

class Pr_Mstr_Model extends Model
{
    protected $table            = 'pr_mstr';
    protected $primaryKey       = 'pr_code';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['pr_code', 'pr_name', 'pr_desc', 'pr_sup', 'pr_total', 'pr_approve', 'pr_approve_desc', 'pr_create_po', 'pr_add_by', 'pr_add_date', 'pr_upd_by', 'pr_upd_date'];
}

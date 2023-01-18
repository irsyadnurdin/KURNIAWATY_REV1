<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class User_Mstr_Model extends Model
{
    protected $table            = 'user_mstr';
    protected $primaryKey       = 'user_id';

    protected $useAutoIncrement = false;
    protected $allowedFields    = ['user_id', 'user_name', 'user_full_name', 'user_email', 'user_role', 'user_password', 'user_token', 'user_image', 'user_active', 'user_last_login'];


    // FUNCTION
    function get_User_Name($user_name)
    {
        $builder = $this->table("user_mstr");
        $data = $builder->where("user_name", $user_name)->first();
        if (!$data) {
            throw new Exception("Data otentikasi tidak ditemukan");
        }
        return $data;
    }
}

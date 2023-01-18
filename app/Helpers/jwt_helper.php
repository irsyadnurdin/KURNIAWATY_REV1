<?php

use App\Models\User_Mstr_Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function get_JWT($otentikasi_Header)
{
    if (is_null($otentikasi_Header)) {
        throw new Exception('Otentikasi JWT Gagal');
    }
    return explode(" ", $otentikasi_Header)[1];
}


function validate_JWT($encode_Token)
{
    $key = getenv('JWT_SECRET_KEY');
    $decode_Token = JWT::decode($encode_Token, new Key($key, 'HS256'));
    $model_Otentikasi = new User_Mstr_Model();
    $model_Otentikasi->get_User_Name($decode_Token->user_name);
}


function create_JWT($user_name)
{
    $waktu_request = time();
    $waktu_token = getenv('JWT_TIME_TO_LIVE');
    $waktu_expired = $waktu_request + $waktu_token;
    $payload = [
        'user_name' => $user_name,
        'iat' => $waktu_request,
        'exp' => $waktu_expired
    ];

    $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'), "HS256");
    return $jwt;
}

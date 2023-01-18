<?php

namespace App\Controllers;

use App\Models\Setting_Mstr_Model;
use App\Models\User_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;

use CodeIgniter\API\ResponseTrait;


class Login extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");

        $this->setting_mstr = new Setting_Mstr_Model();
        $this->user_mstr = new User_Mstr_Model();
    }


    // ===========================================================================
    // REQUIRED DATA
    // ===========================================================================
    public function required()
    {
        $data["setting_mstr"] = $this->setting_mstr->findAll();

        return $data;
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
        $data = $this->required();

        return view("login/index", $data);
    }


    // ===========================================================================
    // AUTH
    // ===========================================================================
    public function auth()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_name" => "required",
                "user_password" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_name = $this->request->getPost("user_name");
                $user_password = $this->request->getPost("user_password");

                $this->user_mstr->join("role_mstr", "role_mstr.role_code = user_mstr.user_role");
                $cek_username = $this->user_mstr->where([
                    "user_name" => $user_name,
                    "user_active" => "Y"
                ])->first();

                if ($cek_username) {
                    if ((md5($user_password)) == $cek_username["user_password"]) {
                        helper('jwt');

                        $access_token = create_JWT($user_name);

                        $session_admin = [
                            "session_admin"     => [
                                "user_id"           => $cek_username["user_id"],
                                "user_name"         => $cek_username["user_name"],
                                "user_full_name"    => $cek_username["user_full_name"],
                                "user_email"        => $cek_username["user_email"],
                                "user_role"         => $cek_username["user_role"],
                                "user_image"        => $cek_username["user_image"],
                                "user_active"       => $cek_username["user_active"],
                                "user_last_login"   => $cek_username["user_last_login"],
                                "role_name"         => $cek_username["role_name"],
                                "access_token"      => $access_token
                            ],
                        ];

                        session()->set($session_admin);

                        $remember_me = $this->request->getPost("remember_me");

                        if ($remember_me == true) {
                            $session_remember_me = [
                                "session_remember_me"       => [
                                    "user_name"         => $cek_username["user_name"],
                                    "user_password"     => $user_password,
                                ]
                            ];

                            session()->set($session_remember_me);
                        } else {
                            unset($_SESSION["session_remember_me"]);
                        }

                        $this->user_mstr->join("role_mstr", "role_mstr.role_code = user_mstr.user_role");
                        $temp = $this->user_mstr->where([
                            "user_id" => $cek_username["user_id"],
                        ])->first();

                        $this->user_mstr->update($temp['user_id'], [
                            "user_last_login" => date("Y-m-d H:i:s", STRTOTIME(date("h:i:sa")))
                        ]);

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Halo " . $user_name . ",",
                            "message"       => "Selamat datang kembali...",
                            "data"          => $temp,
                            "access_token"  => $access_token,
                        ], 200);
                    } else {
                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Password Yang Anda Masukkan Salah!",
                            "data"          => null,
                        ], 200);
                    }
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Username Yang Anda Masukkan Salah!",
                        "data"          => null,
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Maaf, Terjadi Kesalahan Pada Saat Validasi!",
                    "data"          => null,
                    "errors"        => $validation->getErrors(),
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    // ===========================================================================
    // LUPA PASSWORD
    // ===========================================================================

    public function lupa_password()
    {
        $data = $this->required();

        return view("login/lupa_password", $data);
    }

    public function auth_lupa_password()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules(["user_name" => "required"]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_name = $this->request->getPost("user_name");

                $data = $this->user_mstr->where([
                    "user_name" => $user_name,
                    "user_active" => "Y"
                ])->first();

                if ($data) {
                    $user_token = md5((uniqid() . $data["user_name"]) . "kurtbeanscoffee");

                    $this->user_mstr->update($data["user_id"], [
                        "user_token" => $user_token,
                    ]);

                    $mail = service("email");
                    $mail->setTo($data["user_email"]);
                    $mail->setFrom("kurtbeanscoffee@gmail.com", "KURT BEANS COFFEE [CS]");
                    $mail->setSubject("Password Reset Request!");
                    $data["user_token"] = $user_token;
                    $data["setting_mstr"] = $this->setting_mstr->findAll();
                    $mail->setMessage(view("email/reset", $data));

                    if ($mail->send()) {
                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Password Berhasil Direset!",
                            "message"       => "Silahkan Cek Email Anda Untuk Melakukan Konfirmasi!",
                            "data"          => null
                        ], 200);
                    } else {
                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Password Gagal Direset!",
                            "data"          => null,
                        ], 200);
                    }
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Username Yang Anda Masukkan Salah!",
                        "data"          => null,
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Maaf, Terjadi Kesalahan Pada Saat Validasi!",
                    "data"          => null,
                    "errors"        => $validation->getErrors(),
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }


    // ===========================================================================
    // RESET PASSWORD
    // ===========================================================================

    public function reset_password($user_token = null)
    {
        if (!isset($user_token)) {
            return redirect()->to("/login");
        } else {
            $data = $this->required();

            $data["user"] = $this->user_mstr->where([
                "user_token" => $user_token
            ])->first();

            if ($data["user"]) {
                return view("login/reset_password", $data);
            } else {
                return redirect()->to("/login");
            }
        }
    }

    public function auth_reset_password()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules(["user_id" => "required"]);
            $validation->setRules(["password" => "required"]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id");
                $password = $this->request->getPost("password");

                $status = $this->user_mstr->update($user_id, [
                    "user_token" => "",
                    "user_password" => md5($password),
                ]);

                if ($status) {
                    unset($_SESSION["session_remember_me"]);

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Password Berhasil Direset!",
                        "message"       => null,
                        "data"          => null
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Password Gagal Direset!",
                        "data"          => null,
                    ], 200);
                }
            } else {
                return $this->respond([
                    "success"       => false,
                    "t_message"     => "Oops...",
                    "message"       => "Maaf, Terjadi Kesalahan Pada Saat Validasi!",
                    "data"          => null,
                    "errors"        => $validation->getErrors(),
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $th->getMessage()
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                "success"       => false,
                "t_message"     => "Oops...",
                "message"       => $e->getMessage()
            ], 200);
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\User_Mstr_Model;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\RESTful\ResourceController;


class User extends ResourceController
{
    public function __construct()
    {
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->user_mstr = new User_Mstr_Model();
    }


    // ===========================================================================
    // INDEX
    // ===========================================================================
    public function index()
    {
    }


    // ===========================================================================
    // GET USER
    // ===========================================================================
    public function get_user()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_role" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_role = $this->request->getPost("user_role");

                $this->user_mstr->query("SET lc_time_names = 'id_ID';");
                $this->user_mstr->select("
                    *,
                    DATE_FORMAT(user_mstr.user_last_login, '%W, %d %M %Y - %H:%i:%s') AS _user_last_login
                ");
                $this->user_mstr->join("role_mstr", "role_mstr.role_code = user_mstr.user_role");

                $this->user_mstr->where(["user_role" => $user_role]);
                $this->user_mstr->orderBy('user_full_name', 'ASC');
                $data = $this->user_mstr->findAll();

                if ($data) {
                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Berhasil Menyelesaikan Perintah!",
                        "message"       => null,
                        "data"          => $data,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Gagal Menyelesaikan Perintah!",
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
    // INSERT USER
    // ===========================================================================
    public function insert_user()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_id" => "required",
                "user_name" => "required",
                "user_full_name" => "required",
                "user_password" => "required",
                "user_role" => "required",
                "user_email" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id");
                $user_name = $this->request->getPost("user_name");
                $user_full_name = $this->request->getPost("user_full_name");
                $user_password = $this->request->getPost("user_password");
                $user_role = $this->request->getPost("user_role");
                $user_email = $this->request->getPost("user_email");

                $checking_duplication = $this->user_mstr->where([
                    "user_id" => $user_id,
                    "user_name" => $user_name,
                ])->first();

                if (!$checking_duplication) {
                    $status = $this->user_mstr->insert([
                        "user_id" => $user_id,
                        "user_name" => $user_name,
                        "user_full_name" => $user_full_name,
                        "user_password" => md5($user_password),
                        "user_role" => $user_role,
                        "user_email" => $user_email,
                    ]);

                    if ($status) {
                        $temp = $this->user_mstr->where([
                            "user_id" => $user_id,
                        ])->first();

                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Disimpan!",
                            "message"       => null,
                            "data"          => $temp,
                        ], 200);
                    } else {
                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Disimpan!",
                            "data"          => null,
                        ], 200);
                    }
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Disimpan Karena Terjadi Duplikasi!",
                        "data"          => $checking_duplication,
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
    // UPDATE USER
    // ===========================================================================
    public function update_user()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_id" => "required",
                "user_name" => "required",
                "user_full_name" => "required",
                "user_email" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id");
                $user_name = $this->request->getPost("user_name");
                $user_full_name = $this->request->getPost("user_full_name");
                $user_email = $this->request->getPost("user_email");

                $status = $this->user_mstr->update($user_id, [
                    "user_name" => $user_name,
                    "user_full_name" => $user_full_name,
                    "user_email" => $user_email,
                ]);

                if ($status) {
                    $temp = $this->user_mstr->where([
                        "user_id" => $user_id,
                    ])->first();

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Diperbaharui!",
                        "message"       => null,
                        "data"          => $temp,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Diperbaharui!",
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
    // UPDATE USER ACTIVE
    // ===========================================================================
    public function update_user_active()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_id" => "required",
                "user_active" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id");
                $user_active = $this->request->getPost("user_active");

                $status = $this->user_mstr->update($user_id, [
                    "user_active" => $user_active,
                ]);

                if ($status) {
                    $temp = $this->user_mstr->where([
                        "user_id" => $user_id,
                    ])->first();

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Diperbaharui!",
                        "message"       => null,
                        "data"          => $temp,
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Diperbaharui!",
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
    // UPDATE PASSWORD
    // ===========================================================================
    public function update_password()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_id_reset" => "required",
                "user_password_reset" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id_reset");
                $user_password = $this->request->getPost("user_password_reset");

                $status = $this->user_mstr->update($user_id, [
                    "user_password" => md5($user_password),
                ]);

                if ($status) {
                    unset($_SESSION["session_remember_me"]);

                    $temp = $this->user_mstr->where([
                        "user_id" => $user_id,
                    ])->first();

                    return $this->respond([
                        "success"       => true,
                        "t_message"     => "Data Berhasil Diperbaharui!",
                        "message"       => null,
                        "data"          => $temp
                    ], 200);
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Diperbaharui!",
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
    // UPDATE USER IMAGE
    // ===========================================================================
    public function update_user_image()
    {
        try {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                "user_id" => "required",
                "user_image" => "required",
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $user_id = $this->request->getPost("user_id");
                $data = $this->request->getPost("user_image");

                $image_array_1 = explode(";", $data);
                $image_array_2 = explode(",", $image_array_1[1]);

                $foto = base64_decode($image_array_2[1]);
                $fileName = uniqid() . ".png";

                if (file_put_contents("_img/profile/" . $fileName, $foto)) {
                    $temp = $this->user_mstr->find($user_id);

                    if ($temp["user_image"] != "default.png") {
                        $path = "../public/_img/profile/";
                        @unlink($path . $temp["user_image"]);
                    }

                    $status = $this->user_mstr->update($user_id, [
                        "user_image" => $fileName,
                    ]);

                    if ($status) {
                        return $this->respond([
                            "success"       => true,
                            "t_message"     => "Data Berhasil Diperbaharui!",
                            "message"       => null,
                            "data"          => null
                        ], 200);
                    } else {
                        return $this->respond([
                            "success"       => false,
                            "t_message"     => "Oops...",
                            "message"       => "Maaf, Data Gagal Diperbaharui!",
                            "data"          => null,
                        ], 200);
                    }
                } else {
                    return $this->respond([
                        "success"       => false,
                        "t_message"     => "Oops...",
                        "message"       => "Maaf, Data Gagal Diperbaharui!",
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

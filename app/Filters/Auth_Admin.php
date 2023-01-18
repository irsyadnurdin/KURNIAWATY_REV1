<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Exception;

class Auth_Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        session();

        if (!isset($_SESSION['session_admin'])) {
            return redirect()->to('/login');
        } else {
            try {
                helper('jwt');
                // $encode_Token = get_JWT($_SESSION['session_admin']['access_token']);
                validate_JWT($_SESSION['session_admin']['access_token']);
            } catch (Exception $e) {
                unset($_SESSION['session_admin']);

                return redirect()->to('/login');
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

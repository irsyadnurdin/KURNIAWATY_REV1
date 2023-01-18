<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth_Login implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        session();

        if (isset($_SESSION['session_admin'])) {
            return redirect()->to('admin');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

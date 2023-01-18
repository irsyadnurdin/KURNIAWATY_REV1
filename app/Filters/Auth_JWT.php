<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class Auth_JWT implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getServer('HTTP_AUTHORIZATION');

        try {
            helper('jwt');
            $encode_Token = get_JWT($header);
            validate_JWT($encode_Token);
            return $request;
        } catch (Exception $e) {
            return Services::response()->setJSON(
                [
                    "success" => false,
                    "t_message" => "Oops...",
                    "message" => $e->getMessage(),
                    "data" => null,
                ]
            )->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

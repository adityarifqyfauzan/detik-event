<?php

namespace Aditya\DetikTest\Controllers;

use Aditya\DetikTest\Traits\ResponseFormatter;

class Controller
{
    use ResponseFormatter;

    public function unprocessableEntityResponse($message = null)
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = $this->json($message, null, 422);
        return $response;
    }

    public function notFoundResponse($message = null)
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = $this->json($message, null, 404);
        return $response;
    }

    public function okResponse($message = null, $data = null)
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $this->json($message, $data, 200);
        return $response;
    }
    
    public function createdResponse($message = null, $data = null)
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $this->json($message, $data, 201);
        return $response;
    }
    
    public function badRequestResponse($message = null)
    {
        $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
        $response['body'] = $this->json($message, null, 400);
        return $response;
    }
}

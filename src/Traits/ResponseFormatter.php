<?php

namespace Aditya\DetikTest\Traits;

/**
 *  Response JSON Formatter
 */
trait ResponseFormatter
{
    public function json($message = null, $data = null, $code = 200)
    {
        return json_encode([
            "message" => $message,
            "data" => $data
        ], $code);
    }
}

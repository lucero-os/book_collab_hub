<?php

namespace App\Exceptions;

use Exception;

class CustomErrorException extends Exception
{
    protected $customMessage;
    protected $statusCode;

    public function __construct($message = null, $statusCode = 400)
    {
        $this->customMessage = $message ?? 'Something went wrong.';
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->customMessage,
        ], $this->statusCode);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}

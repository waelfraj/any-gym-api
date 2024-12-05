<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomException extends Exception
{
    public function render(): JsonResponse
    {
        $statusCode = $this->getCode() ?: 500;

        $response = [
            'message' => $this->getMessage(),
            'status' => $statusCode,
        ];

        if (app()->environment('production')) {
            unset($response['trace'], $response['code']);
        } else if (config('app.debug')) {
            $response['trace'] = $this->getTrace();
            $response['code'] = $this->getCode();
        }

        return response()->json($response, $statusCode);
    }
}


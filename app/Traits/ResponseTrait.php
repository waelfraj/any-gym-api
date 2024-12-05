<?php

namespace App\Traits;

use App\Dto\ResponseDTO;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    protected function successResponse($data, $message = '', $status = 200): JsonResponse
    {
        $responseDTO = new ResponseDTO($message, $data);
        return response()->json($responseDTO, $status);
    }

    protected function errorResponse($message, $status = 400): JsonResponse
    {
        $responseDTO = new ResponseDTO($message, null);
        return response()->json($responseDTO, $status);
    }
}

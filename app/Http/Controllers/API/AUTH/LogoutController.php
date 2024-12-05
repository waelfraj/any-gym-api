<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\LogoutService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    use ResponseTrait;

    /**
     * @param LogoutService $logoutService
     */
    public function __construct(private readonly LogoutService $logoutService)
    {
    }


    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $logout = $this->logoutService->logout();
            return $this->successResponse($logout, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage, $e->getCode());
        }


    }
}

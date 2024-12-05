<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class SendResetPasswordEmailController extends Controller
{

    use ResponseTrait;

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function __invoke(ForgetPasswordRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->authService->sendPasswordResetToken($request), StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

    }

}

<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckResetPasswordTokenRequest;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class CheckResetPasswordTokenController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @param CheckResetPasswordTokenRequest $request
     * @return JsonResponse
     * @throws InternalErrorException
     */
    public function __invoke(CheckResetPasswordTokenRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->authService->checkResetPasswordToken($request), StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

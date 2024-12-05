<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidationMailTokenRequest;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class MailValidationController extends Controller
{
    use ResponseTrait;

    /**
     * @param AuthService $authService
     */
    public function __construct(private readonly AuthService $authService)
    {
    }


    /**
     * @param CheckValidationMailTokenRequest $request
     * @return JsonResponse
     */
    public function __invoke(CheckValidationMailTokenRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->authService->checkValidationMailToken($request), StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

}

<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendValidationEmailRequest;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class SendValidationEmailController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(SendValidationEmailRequest $request): JsonResponse
    {
        try {
            return $this->successResponse($this->authService->sendValidationMailToken($request), StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

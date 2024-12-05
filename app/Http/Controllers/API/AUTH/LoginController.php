<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly LoginService $loginService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $login = $this->loginService->login($request);
            return $this->successResponse($login, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

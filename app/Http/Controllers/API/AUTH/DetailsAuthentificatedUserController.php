<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DetailsAuthentificatedUserController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AuthService $authService)
    {
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $refresh = $this->authService->me();
            return $this->successResponse($refresh, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage, $e->getCode());
        }
    }
}

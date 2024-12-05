<?php

namespace App\Http\Controllers\API\User;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class EditConnectedUserController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function __invoke(UpdateUserRequest $request): JsonResponse
    {
        try {
            $destroyedStaff = $this->userService->editConnectedUser($request);
            return $this->successResponse($destroyedStaff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

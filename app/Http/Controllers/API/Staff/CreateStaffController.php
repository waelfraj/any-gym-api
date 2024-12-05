<?php

namespace App\Http\Controllers\API\Staff;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Services\StaffService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateStaffController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly StaffService $staffService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreStaffRequest $request): JsonResponse
    {
        try {
            $staff = $this->staffService->create($request);
            return $this->successResponse($staff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

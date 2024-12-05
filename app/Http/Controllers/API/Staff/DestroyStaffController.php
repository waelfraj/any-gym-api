<?php

namespace App\Http\Controllers\API\Staff;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\StaffService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class DestroyStaffController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly StaffService $staffService)
    {
    }

    public function __invoke($id): JsonResponse
    {
        try {
            $destroyedStaff = $this->staffService->destroy($id);
            return $this->successResponse($destroyedStaff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

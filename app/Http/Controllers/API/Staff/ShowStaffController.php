<?php

namespace App\Http\Controllers\API\Staff;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\StaffService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ShowStaffController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly StaffService $staffService)
    {
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function __invoke($id): JsonResponse
    {
        try {
            $staff = $this->staffService->showById($id);
            return $this->successResponse($staff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

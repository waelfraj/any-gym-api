<?php

namespace App\Http\Controllers\API\Staff;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\StaffService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class SearchStaffByNameController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly StaffService $staffService)
    {
    }


    /**
     * @param $name
     * @return JsonResponse
     */
    public function __invoke($name): JsonResponse
    {
        try {
            $staff = $this->staffService->searchByName($name);
            return $this->successResponse($staff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

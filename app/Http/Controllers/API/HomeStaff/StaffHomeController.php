<?php

namespace App\Http\Controllers\API\HomeStaff;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\HomeStaffService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class StaffHomeController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly HomeStaffService $staffHomeService,
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $homeStaff = $this->staffHomeService->home();
            return $this->successResponse($homeStaff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

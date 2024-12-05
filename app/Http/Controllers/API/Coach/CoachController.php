<?php

namespace App\Http\Controllers\API\Coach;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\CoachService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CoachController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly CoachService $coachService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $coach = $this->coachService->getAll();
            return $this->successResponse($coach, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

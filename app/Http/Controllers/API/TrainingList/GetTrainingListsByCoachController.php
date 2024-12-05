<?php

namespace App\Http\Controllers\API\TrainingList;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class GetTrainingListsByCoachController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        try {
            $trainingList = $this->trainingListService->getByCoach();
            return $this->successResponse($trainingList, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\API\TrainingList;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class DestroyTrainingListController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($id): JsonResponse
    {
        try {
            $destroyedTrainingList = $this->trainingListService->destroy($id);
            return $this->successResponse($destroyedTrainingList, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

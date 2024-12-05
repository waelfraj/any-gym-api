<?php

namespace App\Http\Controllers\API\TrainingList;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetTrainingListsByQueryController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $queryParams = $request->query();
            $trainingList = $this->trainingListService->getByQuery($queryParams);
            return $this->successResponse($trainingList, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

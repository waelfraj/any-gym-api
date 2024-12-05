<?php

namespace App\Http\Controllers\API\TrainingList;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateNewTrainingListController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Create new training list.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $trainingList = $this->trainingListService->store($request);
            return $this->successResponse($trainingList, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

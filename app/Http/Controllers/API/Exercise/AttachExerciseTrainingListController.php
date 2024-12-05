<?php

namespace App\Http\Controllers\API\Exercise;

use App\Enums\StatusCode;
use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ExerciseService;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttachExerciseTrainingListController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly ExerciseService     $exerciseService,
        private readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $trainingListId = $request->input('trainingListId');
            $nbrCalories = $request->input('calories');
            $exercise = $this->exerciseService->addExerciseToTrainingList($request);
            $this->trainingListService->addCalories($trainingListId, $nbrCalories);
            return $this->successResponse(StatusType::SUCCESS->value, $exercise, StatusCode::OK->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

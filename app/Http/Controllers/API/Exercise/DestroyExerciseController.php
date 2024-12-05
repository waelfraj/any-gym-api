<?php

namespace App\Http\Controllers\API\Exercise;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ExerciseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class DestroyExerciseController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ExerciseService $exerciseService)
    {
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $exercise = $this->exerciseService->destroy($id);
            return $this->successResponse($exercise, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\API\Exercise;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ExerciseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateExerciseController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ExerciseService $exerciseService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $exercise = $this->exerciseService->store($request);
            return $this->successResponse($exercise, StatusCode::OK->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

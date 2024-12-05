<?php

namespace App\Http\Controllers\API\Exercise;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ExerciseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ExerciseByCategoryController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ExerciseService $exerciseService)
    {
    }


    /**
     * @param string $category
     * @return JsonResponse
     */
    public function __invoke(string $category): JsonResponse
    {
        try {
            $exercise = $this->exerciseService->getByCategory($category);
            return $this->successResponse($exercise, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

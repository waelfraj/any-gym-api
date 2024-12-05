<?php

namespace App\Http\Controllers\API\Exercise;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ExerciseService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ExerciseService $exerciseService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $exercise = $this->exerciseService->getAll();
            return $this->successResponse($exercise, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

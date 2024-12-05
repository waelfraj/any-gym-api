<?php

namespace App\Http\Controllers\API\HomeMember;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\TrainingListService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class HomeMemberController extends Controller
{
    use ResponseTrait;
    public function __construct(public readonly TrainingListService $trainingListService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        try {
            $popularTraining = $this->trainingListService->popularTraining();
            $latestThreeTraining = $this->trainingListService->latestThreeTraining();
            return $this->successResponse(
                [
                    'popularTraining' => $popularTraining,
                    'latestThreeTraining' => $latestThreeTraining
                ], StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

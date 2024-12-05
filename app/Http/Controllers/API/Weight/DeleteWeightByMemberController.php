<?php

namespace App\Http\Controllers\API\Weight;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\WeightService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class DeleteWeightByMemberController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly WeightService $weightService)
    {
    }

    /**
     * Create new training list.
     *
     * @param $weightId
     * @return JsonResponse
     */
    public function __invoke($weightId): JsonResponse
    {
        try {
            $this->weightService->delete($weightId);
            return $this->successResponse('Deleted with success', StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\API\Weight;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\WeightService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class GetWeightByMemberController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly WeightService $weightService)
    {
    }

    /**
     * Create new training list.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $weight = $this->weightService->getAllByMember();
            return $this->successResponse($weight, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

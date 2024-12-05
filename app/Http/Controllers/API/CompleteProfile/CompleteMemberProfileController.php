<?php

namespace App\Http\Controllers\API\CompleteProfile;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteMemberProfileRequest;
use App\Services\MemberService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CompleteMemberProfileController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly MemberService $memberService)
    {
    }

    /**
     * Create new training list.
     *
     * @param CompleteMemberProfileRequest $request
     * @return JsonResponse
     */
    public function __invoke(CompleteMemberProfileRequest $request): JsonResponse
    {
        try {
            $this->memberService->completeProfile($request);
            return $this->successResponse("Profile Completed with success", StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

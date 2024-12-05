<?php

namespace App\Http\Controllers\API\Member;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ValidateMemberController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly MemberService $memberService)
    {
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function __invoke($id): JsonResponse
    {
        try {
            $staff = $this->memberService->validateMember($id);
            return $this->successResponse($staff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

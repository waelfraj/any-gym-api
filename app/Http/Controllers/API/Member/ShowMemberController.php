<?php

namespace App\Http\Controllers\API\Member;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ShowMemberController extends Controller
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
            $member = $this->memberService->showById($id);
            return $this->successResponse($member, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

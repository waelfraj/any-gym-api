<?php

namespace App\Http\Controllers\API\Member;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class SearchMemberByNameController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly MemberService $memberService)
    {
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function __invoke($name): JsonResponse
    {
        try {
            $staff = $this->memberService->searchByName($name);
            return $this->successResponse($staff, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

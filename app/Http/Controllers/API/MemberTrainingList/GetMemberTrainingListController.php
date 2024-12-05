<?php

namespace App\Http\Controllers\API\MemberTrainingList;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class GetMemberTrainingListController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly MemberService $memberService)
    {
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InternalErrorException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $memberTraining = $this->memberService->getMemberToTrainingList($request);
            return $this->successResponse($memberTraining, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

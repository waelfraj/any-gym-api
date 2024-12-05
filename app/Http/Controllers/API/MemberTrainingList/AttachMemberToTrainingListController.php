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

class AttachMemberToTrainingListController extends Controller
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
            $trainingId = $request->input('training_id');
            $attachedTrainingList = $this->memberService->attachMemberToTrainingList($trainingId);
            if ($attachedTrainingList) {
                return $this->successResponse("Attached successfully", StatusType::SUCCESS->value);
            }
            throw new InternalErrorException();
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

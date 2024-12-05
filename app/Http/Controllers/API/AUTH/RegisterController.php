<?php

namespace App\Http\Controllers\API\AUTH;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;


class RegisterController extends Controller
{
    use ResponseTrait;

    /**
     * @param RegisterService $registerService
     */
    public function __construct(private readonly RegisterService $registerService)
    {
    }


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws InternalErrorException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $login = $this->registerService->register($request);
            return $this->successResponse($login, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->successResponse($e->getMessage(), $e->getCode());
        }
    }
}

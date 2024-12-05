<?php

namespace App\Http\Controllers\API\GeminiApi;

use App\Enums\StatusType;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\ChatBotService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class GeminiApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly ChatBotService $chatBotService)
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
            $chat = $this->chatBotService->generateResponse($request);
            return $this->successResponse($chat, StatusType::SUCCESS->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

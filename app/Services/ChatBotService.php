<?php

namespace App\Services;

use App\Enums\ChatBotConstant;
use App\Exceptions\Gemini\NoAPIKeyFoundException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class ChatBotService
{

    /**
     * @param $request
     * @return mixed
     * @throws InternalErrorException
     * @throws NoAPIKeyFoundException
     */
    public function generateResponse($request): mixed
    {
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            throw new NoAPIKeyFoundException();
        }

        $instructions = ChatBotConstant::INSCTRUCTIONS->value;
        $userMessage = $request->message;
        $combinedMessage = $instructions . "\n" . $userMessage;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(ChatBotConstant::CHATBOT_URL_REQUEST->value . $apiKey, [
                'contents' =>
                    [[
                        'role' => ChatBotConstant::ROLE->value,
                        'parts' => [[ChatBotConstant::PARTS_TYPE->value => $combinedMessage,]]
                    ],]
            ]);
            return $response['candidates'][0]['content']['parts'][0]['text'];
        } catch (InternalErrorException $e) {
            throw new InternalErrorException();
        }
    }
}

<?php

namespace App\Exceptions\Gemini;

use App\Enums\ResponseMessage;
use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class NoAPIKeyFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct(ResponseMessage::NO_API_KEY_FOUND->value, StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

<?php

namespace App\Exceptions\TokenExceptions;

use App\Enums\ResponseMessage;
use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class InvalidCredentialException extends CustomException
{
    public function __construct()
    {
        parent::__construct(ResponseMessage::INVALID_CREDENTIALS->value, StatusCode::UNAUTHORIZED->value);
    }
}

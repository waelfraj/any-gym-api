<?php

namespace App\Exceptions\TokenExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class TokenInvalidException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Token invalid.", StatusCode::UNAUTHORIZED->value);
    }
}

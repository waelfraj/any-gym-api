<?php

namespace App\Exceptions\TokenExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class TokenExpiredException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Token expired.", StatusCode::UNAUTHORIZED->value);
    }
}

<?php

namespace App\Exceptions\TokenExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class UnauthorizedException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Unauthorized.", StatusCode::UNAUTHORIZED->value);
    }
}

<?php

namespace App\Exceptions;

use App\Enums\StatusCode;

class ValidationMailException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Validation Mail Exception.", StatusCode::BAD_REQUEST->value);
    }
}


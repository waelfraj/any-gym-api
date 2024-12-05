<?php

namespace App\Exceptions\Weight;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotDeleteWeightException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Weight cannot be deleted.", StatusCode::BAD_REQUEST->value);
    }
}

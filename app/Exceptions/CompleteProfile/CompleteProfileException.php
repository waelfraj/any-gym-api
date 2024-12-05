<?php

namespace App\Exceptions\CompleteProfile;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CompleteProfileException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Complete Profile Exception.", StatusCode::NOT_FOUND->value);
    }
}

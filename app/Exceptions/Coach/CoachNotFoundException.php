<?php

namespace App\Exceptions\Coach;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CoachNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Coach not found.", StatusCode::NOT_FOUND->value);
    }
}

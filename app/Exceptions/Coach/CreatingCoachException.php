<?php

namespace App\Exceptions\Coach;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingCoachException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Coach.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

<?php

namespace App\Exceptions\Coach;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetCoachException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting List of coaches", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

<?php

namespace App\Exceptions\Weight;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetWeightException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting List of Weights", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

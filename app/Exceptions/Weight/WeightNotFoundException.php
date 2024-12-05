<?php

namespace App\Exceptions\Weight;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class WeightNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Weight not found.", StatusCode::NOT_FOUND->value);
    }
}

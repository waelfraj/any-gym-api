<?php

namespace App\Exceptions\Weight;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingWeightException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating weight.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

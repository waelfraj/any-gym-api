<?php

namespace App\Exceptions\Exercise;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingExerciseException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Exercise.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

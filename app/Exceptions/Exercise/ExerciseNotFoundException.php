<?php

namespace App\Exceptions\Exercise;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class ExerciseNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Exercise not found.", StatusCode::NOT_FOUND->value);
    }
}

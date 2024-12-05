<?php

namespace App\Exceptions\Exercise;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class AttachExerciseTrainingListException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Failed to add exercise to training list.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

<?php

namespace App\Exceptions\TrainingListExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingTrainingListException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Training List", StatusCode::BAD_REQUEST->value);
    }
}

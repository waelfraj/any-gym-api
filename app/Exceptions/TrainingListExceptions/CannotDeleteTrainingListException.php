<?php

namespace App\Exceptions\TrainingListExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotDeleteTrainingListException extends CustomException
{
    public function __construct()
    {
        parent::__construct("This training list cannot be deleted.", StatusCode::BAD_REQUEST->value);
    }
}

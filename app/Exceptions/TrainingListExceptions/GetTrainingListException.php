<?php

namespace App\Exceptions\TrainingListExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetTrainingListException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting Training List", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

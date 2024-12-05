<?php

namespace App\Exceptions\TrainingListExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class TrainingListNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Training list not found.", StatusCode::NOT_FOUND->value);
    }
}

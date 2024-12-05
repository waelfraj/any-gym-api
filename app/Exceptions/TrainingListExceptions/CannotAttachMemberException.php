<?php

namespace App\Exceptions\TrainingListExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotAttachMemberException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Cannot attach member to training list due to a constraint violation.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

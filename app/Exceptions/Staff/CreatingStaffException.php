<?php

namespace App\Exceptions\Staff;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingStaffException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Training List.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

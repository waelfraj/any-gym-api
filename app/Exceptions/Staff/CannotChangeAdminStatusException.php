<?php

namespace App\Exceptions\Staff;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotChangeAdminStatusException extends CustomException
{
    public function __construct()
    {
        parent::__construct("The admin status cannot be changed.", StatusCode::BAD_REQUEST->value);
    }
}

<?php

namespace App\Exceptions\Staff;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotDeleteAdminException extends CustomException
{
    public function __construct()
    {
        parent::__construct("The admin cannot be deleted.", StatusCode::BAD_REQUEST->value);
    }
}

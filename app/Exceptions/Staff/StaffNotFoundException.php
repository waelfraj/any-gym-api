<?php

namespace App\Exceptions\Staff;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class StaffNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Staff not found.", StatusCode::NOT_FOUND->value);
    }
}

<?php

namespace App\Exceptions\Staff;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetStaffException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting List of staffs", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

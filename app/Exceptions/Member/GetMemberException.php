<?php

namespace App\Exceptions\Member;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetMemberException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting List of members", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

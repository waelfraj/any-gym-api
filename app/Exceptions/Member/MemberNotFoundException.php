<?php

namespace App\Exceptions\Member;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class MemberNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Member not found.", StatusCode::NOT_FOUND->value);
    }
}

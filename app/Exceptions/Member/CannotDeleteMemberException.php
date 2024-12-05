<?php

namespace App\Exceptions\Member;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CannotDeleteMemberException extends CustomException
{
    public function __construct()
    {
        parent::__construct("This Member cannot be deleted.", StatusCode::BAD_REQUEST->value);
    }
}

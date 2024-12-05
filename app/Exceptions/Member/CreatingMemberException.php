<?php

namespace App\Exceptions\Member;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingMemberException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Member.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

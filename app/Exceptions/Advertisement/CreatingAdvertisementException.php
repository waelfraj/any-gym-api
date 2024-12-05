<?php

namespace App\Exceptions\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CreatingAdvertisementException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while creating Advertisement.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

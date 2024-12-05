<?php

namespace App\Exceptions\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class GetAdvertisementException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Error while getting List of Advertisements", StatusCode::INTERNAL_SERVER_ERROR->value);
    }
}

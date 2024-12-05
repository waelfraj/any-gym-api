<?php

namespace App\Exceptions\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class AdvertisementNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct("Advertisement not found.", StatusCode::NOT_FOUND->value);
    }
}

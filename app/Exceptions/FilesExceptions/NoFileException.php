<?php

namespace App\Exceptions\FilesExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class NoFileException extends CustomException
{
    public function __construct()
    {
        parent::__construct("No File has been uploaded.", StatusCode::BAD_REQUEST->value);
    }
}

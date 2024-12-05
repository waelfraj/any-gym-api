<?php

namespace App\Exceptions\FilesExceptions;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;

class CloudinaryException extends CustomException
{
    public function __construct()
    {
        parent::__construct("An error occurred while uploading the image to Cloudinary.", StatusCode::INTERNAL_SERVER_ERROR->value);
    }

}

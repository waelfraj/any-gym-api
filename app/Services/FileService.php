<?php

namespace App\Services;

use App\Exceptions\FilesExceptions\CloudinaryException;
use App\Exceptions\FilesExceptions\NoFileException;
use Cloudinary\Api\Exception\ApiError;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileService
{
    public function __construct()
    {
    }

    /**
     * @throws CloudinaryException
     * @throws NoFileException
     */
    public function uploadFile($file)
    {
        if ($file->hasFile('image')) {
            try {
                Cloudinary::uploadApi();
                return Cloudinary::upload($file->file('image')->getRealPath())->getSecurePath();
            } catch (ApiError $e) {
                throw new CloudinaryException($e->getMessage(), $e->getCode());
            }
        }
        throw new NoFileException();
    }
}

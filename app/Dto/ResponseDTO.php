<?php

namespace App\Dto;

class ResponseDTO
{
    public string $message;
    public mixed $data;

    public function __construct(string $message, $data = null)
    {
        $this->message = $message;
        $this->data = $data;
    }
}

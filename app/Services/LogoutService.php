<?php

namespace App\Services;

use App\Enums\ResponseMessage;

class LogoutService
{
    /**
     * @return string
     */
    public function logout(): string
    {
        auth()->logout();
        return ResponseMessage::LOGGED_OUT->value;
    }
}

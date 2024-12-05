<?php

namespace App\Repositories;

use App\Models\ResetPassword;
use App\Repositories\Interfaces\PasswordResetRepositoryInterface;
use Illuminate\Support\Carbon;

class PasswordResetRepository implements PasswordResetRepositoryInterface
{
    public function createResetPassword($email,$token)
    {
        return ResetPassword::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function getResetPassword($email)
    {
        return ResetPassword::where('email', $email)->first();
    }

    public function deleteResetPassword($email): void
    {
        ResetPassword::where('email', '<=', $email)->delete();
    }

    public function deleteResetPasswordBeforeTime($formatted): void
    {
        ResetPassword::where('created_at', '<=', $formatted)->delete();
    }

    public function getResetPasswordByToken($token)
    {
        return ResetPassword::where('token', '<=', $token)->first();
    }

}

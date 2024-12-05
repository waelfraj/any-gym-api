<?php

namespace App\Repositories;

use App\Models\MailValidation;
use App\Repositories\Interfaces\MailValidationRepositoryInterface;
use Illuminate\Support\Carbon;

class MailValidationRepository implements MailValidationRepositoryInterface
{
    public function create($email,$token)
    {
        return MailValidation::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }
    public function getMailValidation($email)
    {
        return MailValidation::where('email', $email)->first();
    }

    public function delete($email): void
    {
        MailValidation::where('email', '<=', $email)->delete();
    }

    public function deleteBeforeTime($formatted): void
    {
        MailValidation::where('created_at', '<=', $formatted)->delete();
    }

    public function getByToken($token)
    {
        return MailValidation::where('token', '<=', $token)->first();
    }

}

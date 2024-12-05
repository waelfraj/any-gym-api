<?php

namespace App\Repositories\Interfaces;

interface PasswordResetRepositoryInterface
{
    /**
     * @param $email
     * @param $token
     */
    public function createResetPassword($email,$token);

    /**
     * @param $email
     */
    public function getResetPassword($email);

    /**
     * @param $email
     */
    public function deleteResetPassword($email);

    /**
     * @param $formatted
     */
    public function deleteResetPasswordBeforeTime($formatted);

    /**
     * @param $token
     */
    public function getResetPasswordByToken($token);
}

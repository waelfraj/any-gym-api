<?php

namespace App\Repositories\Interfaces;

interface MailValidationRepositoryInterface
{
    /**
     * @param $email
     * @param $token
     */
    public function create($email, $token);

    /**
     * @param $email
     */
    public function getMailValidation($email);

    /**
     * @param $email
     */
    public function delete($email);

    /**
     * @param $formatted
     */
    public function deleteBeforeTime($formatted);

    /**
     * @param $token
     */
    public function getByToken($token);
}

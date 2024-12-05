<?php

namespace App\Services;

use App\Exceptions\TokenExceptions\InvalidCredentialException;

class LoginService
{
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }


    /**
     * @param $user
     * @return array
     * @throws InvalidCredentialException
     */
    public function login($user): array
    {
        $credentials = $user->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            throw new InvalidCredentialException();
        }
        return $this->authService->respondWithToken($token);
    }
}

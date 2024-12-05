<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface   $userRepository,
    )
    {
    }


    /**
     * @param $request
     */
    public function editConnectedUser($request)
    {
        return $this->userRepository->editConnectedUser($request);
    }

    /**
     * @param $id
     */
    public function deleteUser($id)
    {
        return $this->userRepository->destroy($id);
    }

}

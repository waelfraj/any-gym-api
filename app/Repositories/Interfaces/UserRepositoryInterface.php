<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function create($user);

    public function getUserByEmail($email);

    public function getUserByPassword($loginUserData, $user);

    public function changePassword($user, $password);

    public function ValidateMail($user);

    public function getAll();

    public function getById($id);

    public function getByUserId($id);

    public function update($request, $id);

    public function editConnectedUser($request);


    public function destroy($id);

    public function validateUser($user);

    public function getCurrentUser();
}

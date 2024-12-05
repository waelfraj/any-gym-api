<?php

namespace App\Repositories\Interfaces;

interface MemberRepositoryInterface
{
    public function getAll();

    public function getLastThree();

    public function create($user);

    public function getById($id);

    public function searchByName($name);

    public function destroy($id);

    public function getNumberOfMembers();

    public function validateMember($id);

    public function completeProfile($memberDetails);
}

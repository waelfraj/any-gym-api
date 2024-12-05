<?php

namespace App\Services;

use App\Repositories\Interfaces\StaffRepositoryInterface;

class StaffService
{
    public function __construct(
        private readonly StaffRepositoryInterface $staffRepository,
    )
    {
    }

    public function getAll()
    {
        return $this->staffRepository->getAll();
    }

    public function getLastThree()
    {
        return $this->staffRepository->getlastThree();
    }

    public function showById($id)
    {
        return $this->staffRepository->getById($id);
    }

    public function create($user)
    {
        return $this->staffRepository->create($user);
    }

    public function update($request, $id)
    {
        return $this->staffRepository->update($request, $id);
    }

    public function editConnected($request)
    {
        $user = auth()->user();
        return $this->staffRepository->update($request->toArray(), $user['id']);
    }

    public function destroy($id)
    {
        return $this->staffRepository->destroy($id);
    }

    public function getNumberOfStaffs()
    {
        return $this->staffRepository->getNumberOfStaffs();
    }

    public function validateStaff($id)
    {
        return $this->staffRepository->validateStaff($id);
    }

    public function searchByName($name)
    {
        return $this->staffRepository->searchByName($name);
    }
}

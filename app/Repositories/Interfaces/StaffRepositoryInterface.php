<?php

namespace App\Repositories\Interfaces;

interface StaffRepositoryInterface
{
    public function getAll();
    public function getLastThree();

    public function searchByName($name);

    public function getById($id);

    public function create($user);

    public function update($request, $id);


    public function destroy($id);

    public function getNumberOfStaffs();

    public function validateStaff($id);
}

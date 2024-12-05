<?php

namespace App\Repositories\Interfaces;

interface CoachRepositoryInterface
{
    public function getAll();

    public function getLastThree();


    public function getById($id);

    public function create($user);

    public function validate($id);

    public function destroy($id);

    public function getNumberOfCoaches();

}

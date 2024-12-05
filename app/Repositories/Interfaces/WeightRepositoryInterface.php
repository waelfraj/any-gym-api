<?php

namespace App\Repositories\Interfaces;

interface WeightRepositoryInterface
{
    public function getAllByMember();

    public function store($weight);

    public function delete($weightId);
}

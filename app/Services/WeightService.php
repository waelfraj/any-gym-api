<?php

namespace App\Services;

use App\Repositories\Interfaces\WeightRepositoryInterface;

class WeightService
{
    public function __construct(private readonly WeightRepositoryInterface $weightRepository)
    {
    }

    public function getAllByMember()
    {
        return $this->weightRepository->getAllByMember();
    }


    public function store($weight)
    {
        return $this->weightRepository->store($weight);
    }

    public function delete($weightId)
    {
        return $this->weightRepository->delete($weightId);
    }

}

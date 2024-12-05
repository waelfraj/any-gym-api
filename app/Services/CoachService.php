<?php

namespace App\Services;

use App\Repositories\Interfaces\CoachRepositoryInterface;

class CoachService
{
    public function __construct(private readonly CoachRepositoryInterface $coachRepository)
    {
    }

    public function getAll()
    {
        return $this->coachRepository->getAll();
    }

    public function getLastThree()
    {
        return $this->coachRepository->getlastThree();
    }

    public function showById($id)
    {
        return $this->coachRepository->getById($id);
    }

    public function create($user)
    {
        return $this->coachRepository->create($user);
    }

    public function validateCoach($id)
    {
        return $this->coachRepository->validate($id);
    }

    public function destroy($id)
    {
        return $this->coachRepository->destroy($id);
    }

    public function getNumberOfCoaches()
    {
        return $this->coachRepository->getNumberOfCoaches();
    }
}

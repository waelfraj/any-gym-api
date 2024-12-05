<?php

namespace App\Repositories\Interfaces;

interface AppointmentRepositoryInterface
{
    public function getAll();

    public function create($request);

    public function findById($appointmentId);

    public function countMembers($appointment);

    public function attachMember($appointment, $userId);

    public function isMemberParticipating($appointment, $userId);

}

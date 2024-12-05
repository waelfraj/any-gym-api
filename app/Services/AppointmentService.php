<?php

namespace App\Services;

use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Carbon\Carbon;

class AppointmentService
{

    public function __construct(
        private readonly AppointmentRepositoryInterface $appointmentRepository,
        private readonly AuthService                    $authService
    )
    {
    }

    public function getAll()
    {
        return $this->appointmentRepository->getAll();
    }

    public function create($request)
    {
        return $this->appointmentRepository->create($request);
    }

    /**
     * @param $appointmentId
     * @return array
     */
    public function participate($appointmentId): array
    {
        $appointment = $this->appointmentRepository->findById($appointmentId);

        if ($appointment->start_date < Carbon::now()) {
            return ['status' => false, 'message' => 'La date du rendez-vous est déjà passée.'];
        }

        $user = $this->authService->getCurrentUser();

        if ($this->appointmentRepository->isMemberParticipating($appointment, $user)) {
            return ['status' => false, 'message' => 'Vous participez déjà à ce rendez-vous.'];
        }

        $numberOfParticipants = $this->appointmentRepository->countMembers($appointment);
        if ($numberOfParticipants >= $appointment->number_participation) {
            return ['status' => false, 'message' => 'Le nombre maximal de participants est déjà atteint pour ce rendez-vous.'];
        }

        $this->appointmentRepository->attachMember($appointment, $user);

        return ['status' => true, 'message' => 'Participation confirmée avec succès !'];
    }

}

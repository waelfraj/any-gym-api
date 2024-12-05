<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\Collection;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function getAll(): Collection|array
    {
        return Appointment::with(['coach.user', 'members.user'])->get();
    }

    /**
     * @param $request
     * @return Appointment
     */
    public function create($request): Appointment
    {
        $appointment = new Appointment([
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'coach_id' => $this->authService->getCurrentUser(),
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'number_participation' => $request->input('number_participation'),
            'room' => $request->input('room'),
        ]);
        $appointment->save();
        return $appointment;
    }

    /**
     * @param $appointmentId
     * @return mixed
     */
    public function findById($appointmentId): mixed
    {
        return Appointment::findOrFail($appointmentId);
    }

    /**
     * @param $appointment
     * @return mixed
     */
    public function countMembers($appointment): mixed
    {
        return $appointment->members()->count();
    }

    /**
     * @param $appointment
     * @param $userId
     * @return void
     */
    public function attachMember($appointment, $userId): void
    {
        $appointment->members()->attach($userId);
    }

    /**
     * @param $appointment
     * @param $userId
     * @return mixed
     */
    public function isMemberParticipating($appointment, $userId): mixed
    {
        return $appointment->members()->where('members.id', $userId)->exists();
    }
}

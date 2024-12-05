<?php

namespace App\Http\Controllers\API\Appointment;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ParticipateAppointmentController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AppointmentService $appointmentService)
    {
    }

    /**
     * Gère la participation des membres à un rendez-vous.
     *
     * @param $appointmentId
     * @return JsonResponse
     */
    public function __invoke($appointmentId): JsonResponse
    {
        $result = $this->appointmentService->participate($appointmentId);

        if ($result['status']) {
            return $this->successResponse($result['message'], StatusCode::OK->value);
        }
        return $this->errorResponse($result['message'], StatusCode::HTTP_UNPROCESSABLE_ENTITY->value);
    }
}

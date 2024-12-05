<?php

namespace App\Http\Controllers\API\Appointment;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AppointmentService $appointmentService)
    {
    }

    /**
     * Récupère toutes les réservations.
     *
     * @return JsonResponse
     */

    public function __invoke(): JsonResponse
    {
        $appointments = $this->appointmentService->getAll();
        return $this->successResponse($appointments, StatusCode::OK->value);
    }


}

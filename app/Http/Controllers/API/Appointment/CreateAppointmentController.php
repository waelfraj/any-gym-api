<?php

namespace App\Http\Controllers\API\Appointment;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAppointmentRequest;
use App\Services\AppointmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAppointmentController extends Controller
{

    use ResponseTrait;

    public function __construct(private readonly AppointmentService $appointmentService)
    {
    }


    /**
     * @param CreateAppointmentRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateAppointmentRequest $request): JsonResponse
    {
        $appointment = $this->appointmentService->create($request);
        if ($appointment) {
            return $this->successResponse($appointment, StatusCode::CREATED->value);
        } else {
            return $this->errorResponse('error while creating appointment', StatusCode::CREATED->value);
        }
    }
}

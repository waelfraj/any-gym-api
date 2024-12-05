<?php

namespace App\Http\Controllers\API\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Services\AdvertisementImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class AdvertisementApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AdvertisementImageService $advertisementImageService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $advertisement = $this->advertisementImageService->index();
            return $this->successResponse($advertisement, StatusCode::OK->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

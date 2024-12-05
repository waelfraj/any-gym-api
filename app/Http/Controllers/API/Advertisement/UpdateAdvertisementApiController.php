<?php

namespace App\Http\Controllers\API\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementImageUpdateRequest;
use App\Services\AdvertisementImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class UpdateAdvertisementApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AdvertisementImageService $advertisementImageService)
    {
    }

    /**
     * @param string $id
     * @param AdvertisementImageUpdateRequest $request
     * @return JsonResponse
     */
    public function __invoke(string $id, AdvertisementImageUpdateRequest $request): JsonResponse
    {
        try {
            $advertisement = $this->advertisementImageService->update($id, $request);
            return $this->successResponse($advertisement, StatusCode::OK->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

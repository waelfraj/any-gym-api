<?php

namespace App\Http\Controllers\API\Advertisement;

use App\Enums\StatusCode;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementImageStoreRequest;
use App\Services\AdvertisementImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class CreateAdvertisementApiController extends Controller
{
    use ResponseTrait;

    public function __construct(private readonly AdvertisementImageService $advertisementImageService)
    {
    }

    /**
     * @param AdvertisementImageStoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(AdvertisementImageStoreRequest $request): JsonResponse
    {
        try {
            $advertisement = $this->advertisementImageService->create($request);
            return $this->successResponse($advertisement, StatusCode::OK->value);
        } catch (CustomException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}

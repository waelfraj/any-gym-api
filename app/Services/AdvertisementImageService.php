<?php

namespace App\Services;

use App\Enums\ResponseMessage;
use App\Exceptions\CustomException;
use App\Repositories\Interfaces\AdvertisementImageRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class AdvertisementImageService
{
    public function __construct(private readonly AdvertisementImageRepositoryInterface $advertisementImageRepository,
                                private readonly FileService                           $fileService
    )
    {
    }

    public function index()
    {
        return $this->advertisementImageRepository->getAll();
    }

    public function show($id)
    {
        return $this->advertisementImageRepository->getById($id);
    }

    public function last()
    {
        return $this->advertisementImageRepository->getLastItem();
    }

    /**
     * @param $request
     * @return mixed
     * @throws InternalErrorException
     */
    public function create($request): mixed
    {
        try {
            // Upload image
            $imageName = $this->fileService->uploadFile($request, 'image');

            // Create
            $request['imageName'] = $imageName;
            return $this->advertisementImageRepository->create($request);

        } catch (CustomException $e) {
            throw new InternalErrorException();
        }
    }

    /**
     * @param $id
     * @param $request
     * @return string
     * @throws InternalErrorException
     */
    public function update($id, $request): string
    {
        try {
            $advertisementImage = $this->advertisementImageRepository->getById($id);

            if ($request->hasFile('image')) {
                $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                $advertisementImage['image'] = $imageName;

                // Delete Old and Save the new Image in Storage folder
                if (Storage::disk('advertisement_images')->exists($advertisementImage->image)) {
                    Storage::disk('advertisement_images')->delete($advertisementImage->image);
                }
                Storage::disk('advertisement_images')->put($imageName, file_get_contents($request->image));
            }
            if ($request->name) {
                $advertisementImage['name'] = $request['name'];
            }
            if ($request->description) {
                $advertisementImage['description'] = $request['description'];
            }

            $this->advertisementImageRepository->update($id, $advertisementImage);
            return ResponseMessage::UPDATED_SUCCESS->value;

        } catch (CustomException $e) {
            throw new InternalErrorException();
        }
    }


    public function destroy($id)
    {
        return $this->advertisementImageRepository->delete($id);
    }
}

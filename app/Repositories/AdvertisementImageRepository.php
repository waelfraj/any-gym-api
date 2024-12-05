<?php

namespace App\Repositories;

use App\Exceptions\Advertisement\AdvertisementNotFoundException;
use App\Exceptions\Advertisement\CreatingAdvertisementException;
use App\Exceptions\Advertisement\GetAdvertisementException;
use App\Models\AdvertisementImage;
use App\Repositories\Interfaces\AdvertisementImageRepositoryInterface;

class AdvertisementImageRepository implements AdvertisementImageRepositoryInterface
{
    /**
     * @param $image
     * @return mixed
     * @throws CreatingAdvertisementException
     */
    public function create($image): mixed
    {
        $advertisement = AdvertisementImage::create([
            'name' => $image->name,
            'image' => $image->imageName,
            'description' => $image->description
        ]);
        return $advertisement ?: throw new CreatingAdvertisementException();

    }

    /**
     * @return mixed
     * @throws GetAdvertisementException
     */
    public function getAll(): mixed
    {
        $advertisement = AdvertisementImage::orderBy('id', 'desc')->paginate(10);
        return $advertisement ?: throw new GetAdvertisementException();

    }

    /**
     * @param $id
     * @return mixed
     * @throws AdvertisementNotFoundException
     */
    public function getById($id): mixed
    {
        return AdvertisementImage::findOr($id, fn() => throw new AdvertisementNotFoundException());
    }

    /**
     * @return mixed
     * @throws AdvertisementNotFoundException
     */
    public function getLastItem(): mixed
    {
        $advertisement = AdvertisementImage::latest()->first();
        return $advertisement ?: throw new AdvertisementNotFoundException();
    }

    /**
     * @param $id
     * @param $image
     * @return mixed
     * @throws AdvertisementNotFoundException
     */
    public function update($id, $image): mixed
    {
        $ad = $this->getById($id);
        return $ad->update([
            'name' => $image->name,
            'description' => $image->description,
            'image' => $image->image,
        ]);
    }

    /**
     * @param $id
     * @return bool
     * @throws AdvertisementNotFoundException
     */
    public function delete($id): bool
    {
        $advertisement = $this->getById($id);
        $advertisement->delete();
        return true;
    }
}

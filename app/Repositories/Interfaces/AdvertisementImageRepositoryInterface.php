<?php

namespace App\Repositories\Interfaces;

interface AdvertisementImageRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function getLastItem();

    public function create($image);

    public function update($id, $image);

    public function delete($id);
}

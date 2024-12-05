<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\TrainingListRepositoryInterface;

class TrainingListService
{
    public function __construct(
        private readonly TrainingListRepositoryInterface $trainingListRepository,
        private readonly FileService                     $fileService)
    {
    }

    public function getAll()
    {
        return $this->trainingListRepository->getAll();
    }


    public function getByCoach()
    {
        return $this->trainingListRepository->getByCoach();
    }

    public function getByQuery($queryParams)
    {
        return $this->trainingListRepository->getByQuery($queryParams);
    }

    /**
     * @throws CustomException
     */
    public function store($request)
    {
        try {
            $imageName = $this->fileService->uploadFile($request);
            $request['imageName'] = $imageName;
            return $this->trainingListRepository->create($request);
        } catch (CustomException $e) {
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(int $trainingList)
    {
        return $this->trainingListRepository->destroy($trainingList);
    }

    public function removeExerciseFromList($idList, $idExercise)
    {
        return $this->trainingListRepository->removeExerciseFromList($idList, $idExercise);

    }

    /**
     * @param $trainingListId
     * @param $nbrCalories
     * @return void
     */
    public function addCalories($trainingListId, $nbrCalories): void
    {
        $this->trainingListRepository->addCalories($trainingListId, $nbrCalories);
    }

    public function popularTraining()
    {
        return $this->trainingListRepository->popularTraining();
    }


    public function latestThreeTraining()
    {
        return $this->trainingListRepository->lastThreeTraining();
    }


}

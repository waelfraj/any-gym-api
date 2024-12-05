<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Exceptions\Exercise\AttachExerciseTrainingListException;
use App\Repositories\Interfaces\ExerciseRepositoryInterface;
use App\Repositories\Interfaces\TrainingListRepositoryInterface;

class ExerciseService
{
    public function __construct(
        private readonly ExerciseRepositoryInterface     $exerciseRepository,
        private readonly TrainingListRepositoryInterface $trainingListRepository,
        private readonly FileService                     $fileService
    )
    {
    }

    /**
     * @return mixed
     */
    public function getAll(): mixed
    {
        return $this->exerciseRepository->getAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return $this->exerciseRepository->getById($id);
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getByCategory($category): mixed
    {
        return $this->exerciseRepository->getByCategory($category);
    }

    /**
     * @param $exercise
     * @return mixed
     * @throws CustomException
     */
    public function store($exercise): mixed
    {
        try {
            $imageName = $this->fileService->uploadFile($exercise);
            $exercise['imageName'] = $imageName;
            return $this->exerciseRepository->create($exercise);
        } catch (CustomException $e) {
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $request
     * @return mixed
     * @throws AttachExerciseTrainingListException
     */
    public function addExerciseToTrainingList($request): mixed
    {
        try {
            $trainingListId = $request->trainingListId;
            $this->trainingListRepository->findById($trainingListId);
            $exercise = $this->exerciseRepository->create($request);
            return $this->exerciseRepository->addExerciseToTrainingList($trainingListId, $exercise);
        } catch (CustomException $e) {
            throw new AttachExerciseTrainingListException();
        }
    }

    /**
     * @param int $exercise
     * @return mixed
     */
    public function destroy(int $exercise): mixed
    {
        return $this->exerciseRepository->destroy($exercise);
    }

}

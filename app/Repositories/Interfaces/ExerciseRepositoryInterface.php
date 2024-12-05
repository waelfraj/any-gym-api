<?php

namespace App\Repositories\Interfaces;

interface ExerciseRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function getByCategory($category);

    public function create(array $exercise);

    public function addExerciseToTrainingList($trainingListId, $exercise);

    public function destroy($id);

}

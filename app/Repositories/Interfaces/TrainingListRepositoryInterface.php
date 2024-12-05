<?php

namespace App\Repositories\Interfaces;

interface TrainingListRepositoryInterface
{
    public function getAll();

    public function getByCoach();

    public function getByQuery($queryParams);

    public function create($request);

    public function destroy($trainingListId);

    public function removeExerciseFromList($idList, $idExercise);

    public function findById($trainingList);

    public function attachMember($trainingId);

    public function addCalories($idList, $nbrCalories);

    public function getTrainingListByMemberId($memberId);

    public function popularTraining();

    public function lastThreeTraining();
}

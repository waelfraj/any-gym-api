<?php

namespace App\Repositories;

use App\Exceptions\Exercise\CreatingExerciseException;
use App\Exceptions\Exercise\ExerciseNotFoundException;
use App\Exceptions\Exercise\GetExerciseException;
use App\Models\Exercise;
use App\Repositories\Interfaces\ExerciseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ExerciseRepository implements ExerciseRepositoryInterface
{
    /**
     * @return mixed
     * @throws GetExerciseException
     */
    public function getAll(): mixed
    {
        $exercise = Exercise::orderBy('id', 'desc')->paginate(10);
        return $exercise ?: throw new GetExerciseException();
    }

    /**
     * @param $id
     * @return mixed
     * @throws ExerciseNotFoundException
     */
    public function getById($id): mixed
    {
        return Exercise::findOr($id, fn() => throw new ExerciseNotFoundException());
    }

    /**
     * @param $category
     * @return LengthAwarePaginator
     * @throws GetExerciseException
     */
    public function getByCategory($category): LengthAwarePaginator
    {
        $exercise = Exercise::where('category', $category)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $exercise ?: throw new GetExerciseException();
    }

    /**
     * @param $exercise
     * @return mixed
     * @throws CreatingExerciseException
     */
    public function create($exercise): mixed
    {
        $exercise = Exercise::create([
            'title' => $exercise->title,
            'image' => $exercise->imageName,
            "difficulty" => $exercise->difficulty,
            'description' => $exercise->description,
            "category" => $exercise->category,
            "calories" => $exercise->calories,
            "sets" => $exercise->sets,
        ]);
        return $exercise ?: throw new CreatingExerciseException();
    }

    /**
     * @param $trainingListId
     * @param $exercise
     * @return mixed
     */
    public function addExerciseToTrainingList($trainingListId, $exercise): mixed
    {
        $exercise->training_lists()->attach($trainingListId);
        return $exercise;
    }


    /**
     * @param $id
     * @return mixed
     * @throws ExerciseNotFoundException
     */
    public function destroy($id): mixed
    {
        $exercise = $this->getById($id);
        return $exercise->delete();
    }

}

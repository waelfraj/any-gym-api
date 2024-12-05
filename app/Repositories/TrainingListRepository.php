<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Exceptions\TrainingListExceptions\CannotAttachMemberException;
use App\Exceptions\TrainingListExceptions\CannotDeleteTrainingListException;
use App\Exceptions\TrainingListExceptions\CreatingTrainingListException;
use App\Exceptions\TrainingListExceptions\GetTrainingListException;
use App\Exceptions\TrainingListExceptions\TrainingListNotFoundException;
use App\Models\TrainingList;
use App\Repositories\Interfaces\TrainingListRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Pagination\LengthAwarePaginator;

class TrainingListRepository implements TrainingListRepositoryInterface
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @return LengthAwarePaginator
     * @throws GetTrainingListException
     */
    public function getAll(): LengthAwarePaginator
    {
        $trainingList = TrainingList::with('exercises')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $trainingList ?: throw new GetTrainingListException();
    }

    /**
     * @return LengthAwarePaginator
     * @throws GetTrainingListException
     */
    public function getByCoach():LengthAwarePaginator
    {
        $userId = $this->authService->getCurrentUser();
        $trainingList = TrainingList::with('exercises')
            ->where('coach_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $trainingList ?: throw  new GetTrainingListException();
    }

    /**
     * @param $queryParams
     * @return LengthAwarePaginator
     * @throws GetTrainingListException
     */
    public function getByQuery($queryParams): LengthAwarePaginator
    {
        $userId = $this->authService->getCurrentUser();

        $title = isset($queryParams['title']) ? '%' . $queryParams['title'] . '%' : '%%';

        $trainingList = TrainingList::with('exercises')
            ->where('coach_id', $userId)
            ->where('title', 'LIKE', $title)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return $trainingList ?: throw new GetTrainingListException();
    }


    /**
     * @throws CreatingTrainingListException
     */
    public function create($request)
    {
        $request->merge(["coach_id" => $this->authService->getCurrentUser()]);
        $trainingList = TrainingList::create([
            "coach_id" => $request->coach_id,
            'title' => $request->title,
            'image' => $request->imageName,
            "difficulty" => $request->difficulty,
            'description' => $request->description
        ]);

        if (!$trainingList) throw new CreatingTrainingListException();
        $trainingList->load('exercises');
        return $trainingList;
    }


    /**
     * @param $trainingList
     * @return mixed
     * @throws TrainingListNotFoundException
     */
    public function findById($trainingList) : mixed
    {
        return TrainingList::findOr($trainingList, fn() => throw new TrainingListNotFoundException());
    }


    /**
     * @param $trainingListId
     * @return bool
     * @throws CannotDeleteTrainingListException
     * @throws TrainingListNotFoundException
     */
    public function destroy($trainingListId) :  bool
    {

        $trainingList = $this->findById($trainingListId);

        if (!$this->canBeDeleted($trainingList)) {
            throw new CannotDeleteTrainingListException();
        }
        $trainingList->delete();
        return true;
    }

    /**
     * @param $idList
     * @param $idExercise
     * @return mixed
     * @throws TrainingListNotFoundException
     */
    public function removeExerciseFromList($idList, $idExercise): mixed
    {
        $trainingList = $this->findById($idList);
        $trainingList->exercises()->detach($idExercise);
        $trainingList->load('exercises');
        return $trainingList;
    }


    /**
     * @param $trainingId
     * @return bool
     * @throws CannotAttachMemberException
     * @throws CustomException
     * @throws TrainingListNotFoundException
     */
    public function attachMember($trainingId): bool
    {
        $userId = $this->authService->getCurrentUser();
        $trainingList = $this->findById($trainingId);
        $attachedTraining = $trainingList->members()->attach($userId);
        return $attachedTraining === null ? true : throw new CannotAttachMemberException();
    }


    /**
     * @param $idList
     * @param $nbrCalories
     * @return void
     * @throws TrainingListNotFoundException
     */
    public function addCalories($idList, $nbrCalories): void
    {
        $trainingListData = $this->findById($idList);
        $totalCalories = intval($nbrCalories) + $trainingListData->total_calories;
        $trainingListData->total_calories = $totalCalories;
        $trainingListData->save();
    }

    /**
     * @param $memberId
     * @return mixed
     * @throws GetTrainingListException
     */
    public function getTrainingListByMemberId($memberId): mixed
    {
        $trainingList = TrainingList::with('coach.user')->whereHas('members', function ($query) use ($memberId) {
            $query->where('members.id', $memberId);
        })->with(['members' => function ($query) use ($memberId) {
            $query->where('members.id', $memberId)
                ->select('members.id', 'member_training_list.created_at as pivot_created_at');
        }])
            ->select('id', 'coach_id', 'title', 'description', 'image', 'is_reserved', 'total_calories', 'difficulty', 'training_lists.created_at', 'updated_at')
            ->get();
        return $trainingList ?: throw new GetTrainingListException();

    }


    /**
     * @return mixed
     * @throws GetTrainingListException
     */
    public function popularTraining(): mixed
    {
        $trainingList = TrainingList::with('coach.user')
            ->withCount('members')
            ->with('exercises')
            ->orderByDesc('members_count')
            ->limit(3)
            ->get();
        return $trainingList ?: throw new GetTrainingListException();

    }


    /**
     * @return mixed
     * @throws GetTrainingListException
     */
    public function lastThreeTraining(): mixed
    {
        $trainingList = TrainingList::with('coach.user')
            ->orderByDesc('created_at')
            ->with('exercises')
            ->limit(3)
            ->get();
        return $trainingList ?: throw new GetTrainingListException();

    }

    private function canBeDeleted($trainingList): bool
    {
        return $trainingList->coach_id == $this->authService->getCurrentUser();
    }
}

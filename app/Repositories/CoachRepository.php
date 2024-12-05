<?php

namespace App\Repositories;

use App\Constants\RolesType;
use App\Exceptions\Coach\CoachNotFoundException;
use App\Exceptions\Coach\CreatingCoachException;
use App\Exceptions\Coach\GetCoachException;
use App\Models\Coach;
use App\Repositories\Interfaces\CoachRepositoryInterface;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class CoachRepository implements CoachRepositoryInterface
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @return LengthAwarePaginator
     * @throws GetCoachException
     */
    public function getAll(): LengthAwarePaginator
    {
        $coach = Coach::with('user')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $coach ?: throw new GetCoachException();

    }

    /**
     * @return mixed
     * @throws GetCoachException
     */
    public function getLastThree(): mixed
    {
        $coach = Coach::orderBy('id', 'desc')->take(3)->with('user')->get();
        return $coach ?: throw new GetCoachException();
    }


    /**
     * @param $id
     * @return mixed
     * @throws CoachNotFoundException
     */
    public function getById($id): mixed
    {
        return Coach::findOr($id, fn() => throw new CoachNotFoundException())->load('user');

    }

    /**
     * @param $user
     * @return mixed
     * @throws CreatingCoachException
     */
    public function create($user): mixed
    {
        $coach = Coach::create()->user()->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
            'address' => $user->address,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'role_id' => RolesType::RolesType['COACH_ROLE']['ID'],
        ]);
        return $coach ?: throw new CreatingCoachException();

    }

    /**
     * @param $id
     * @return bool
     * @throws CoachNotFoundException
     */
    public function destroy($id): bool
    {
        $coach = $this->getById($id);
        $this->userService->deleteUser($coach->user->id);
        $coach->delete();
        return true;
    }

    public function getNumberOfCoaches()
    {
        return Coach::count();
    }

    /**
     * @param $id
     * @return mixed
     * @throws CoachNotFoundException
     */
    public function validate($id): mixed
    {
        return $this->changeStatus($this->getById($id));
    }

    /**
     * @param $coach
     * @return mixed
     */
    private function changeStatus($coach): mixed
    {
        if ($coach->user->verified_at == 0) {
            $coach->user->verified_at = 1;
        } else {
            $coach->user->verified_at = 0;
        }
        $coach->user->save();
        return $coach;
    }
}

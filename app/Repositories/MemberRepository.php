<?php

namespace App\Repositories;

use App\Constants\RolesType;
use App\Exceptions\CompleteProfile\CompleteProfileException;
use App\Exceptions\Member\CreatingMemberException;
use App\Exceptions\Member\GetMemberException;
use App\Exceptions\Member\MemberNotFoundException;
use App\Exceptions\Staff\CannotChangeAdminStatusException;
use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Pagination\LengthAwarePaginator;

class MemberRepository implements MemberRepositoryInterface
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @return LengthAwarePaginator
     * @throws GetMemberException
     */
    public function getAll(): LengthAwarePaginator
    {
        $member = Member::with('user')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $member ?: throw new GetMemberException();

    }

    /**
     * @return mixed
     * @throws GetMemberException
     */
    public function getLastThree(): mixed
    {
        $member = Member::orderBy('id', 'desc')->take(3)->with('user')->get();
        return $member ?: throw new GetMemberException();
    }

    /**
     * @param $id
     * @return mixed
     * @throws MemberNotFoundException
     */
    public function getById($id): mixed
    {
        return Member::findOr($id, fn() => throw new MemberNotFoundException())->load('user');
    }

    /**
     * @param $user
     * @return mixed
     * @throws CreatingMemberException
     */
    public function create($user): mixed
    {
        $member = Member::create([
            'objective_id' => $user->objective_id,
            'height' => $user->height,
            'target_weight' => $user->target_weight,
            'age' => $user->age,
            'physical_activity_level' => $user->physical_activity_level,
        ]);

        if (!$member) {
            throw new CreatingMemberException();
        }

        $member->user()->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'address' => $user->address,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'role_id' => RolesType::RolesType['MEMBER_ROLE']['ID'],
        ]);

        return $member;
    }


    /**
     * @param $name
     * @return mixed
     * @throws GetMemberException
     */
    public function searchByName($name): mixed
    {
        try {
            return Member::whereHas('user', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            })->get()
                ->load('user');
        } catch (GetMemberException $e) {
            throw new GetMemberException();
        }
    }

    public function update($request, $id)
    {
        $member = Member::find($id);
        return $member->update($request);
    }

    /**
     * @param $id
     * @return mixed
     * @throws CannotChangeAdminStatusException
     * @throws MemberNotFoundException
     */
    public function validateMember($id): mixed
    {
        return $this->changeStatus($this->getById($id));

    }

    /**
     * @param $member
     * @return mixed
     * @throws CannotChangeAdminStatusException
     */
    private function changeStatus($member): mixed
    {
        if ($member->user->verified_at == 0) {
            $member->user->verified_at = 1;
        } else {
            $member->user->verified_at = 0;
        }
        $member->user->save();
        return $member;
    }


    /**
     * @param $memberDetails
     * @return mixed
     * @throws CompleteProfileException
     * @throws MemberNotFoundException
     */
    public function completeProfile($memberDetails): mixed
    {
        $id = $this->authService->getCurrentUser();
        $member = $this->getById($id);

        $member->age = $memberDetails->get('age');
        $member->objective_id = $memberDetails->get('objective_id');
        $member->height = $memberDetails->get('height');
        $member->target_weight = $memberDetails->get('target_weight');
        $member->physical_activity_level = $memberDetails->get('physical_activity_level');

        $completedProfile = $member->save($memberDetails->all());
        if ($completedProfile) {
            return $completedProfile;
        }
        throw new CompleteProfileException();
    }


    /**
     * @param $id
     * @return bool
     * @throws MemberNotFoundException
     */
    public function destroy($id): bool
    {
        $member = $this->getById($id);
        $this->userService->deleteUser($member->user->id);
        $member->delete();
        return true;

    }

    public function getNumberOfMembers()
    {
        return Member::count();
    }
}

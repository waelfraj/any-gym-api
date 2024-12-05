<?php

namespace App\Repositories;

use App\Constants\AdminInfo;
use App\Constants\RolesType;
use App\Exceptions\CustomException;
use App\Exceptions\Staff\CannotChangeAdminStatusException;
use App\Exceptions\Staff\CannotDeleteAdminException;
use App\Exceptions\Staff\CannotDeleteStaffException;
use App\Exceptions\Staff\CreatingStaffException;
use App\Exceptions\Staff\GetStaffException;
use App\Exceptions\Staff\StaffNotFoundException;
use App\Models\Staff;
use App\Repositories\Interfaces\StaffRepositoryInterface;
use App\Services\AuthService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StaffRepository implements StaffRepositoryInterface
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService
    )
    {
    }

    /**
     * @return LengthAwarePaginator
     * @throws GetStaffException
     */
    public function getAll(): LengthAwarePaginator
    {
        $staff = Staff::with('user')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $staff ?: throw new GetStaffException();

    }

    public function getLastThree()
    {
        return Staff::orderBy('id', 'desc')->take(3)->with('user')->get();
    }


    /**
     * @param $name
     * @return mixed
     * @throws GetStaffException
     */
    public function searchByName($name): mixed
    {
        try {
            return Staff::whereHas('user', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            })->get()
                ->load('user');
        } catch (CustomException $e) {
            throw new GetStaffException();
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws StaffNotFoundException
     */
    public function getById($id): mixed
    {
        return Staff::findOr($id, fn() => throw new StaffNotFoundException())->load('user');
    }

    /**
     * @param $user
     * @return mixed
     * @throws CreatingStaffException
     */
    public function create($user): mixed
    {
        $staff = Staff::create()->user()->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'address' => $user->address,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'verified_at' => 1,
            'email_verified_at' => Carbon::now(),
            'role_id' => RolesType::RolesType['STAFF_ROLE']['ID'],
        ]);
        return $staff ?: throw new CreatingStaffException();

    }

    public function update($request, $id)
    {
        $staff = Staff::find($id);
        return $staff->update($request);
    }

    /**
     * @param $id
     * @return bool
     * @throws CannotDeleteAdminException
     * @throws CannotDeleteStaffException
     * @throws StaffNotFoundException
     */
    public function destroy($id): bool
    {
        $staff = $this->getById($id);
        $this->canBeDeleted($id);
        $this->userService->deleteUser($staff->user->id);
        $staff->delete();
        return true;

    }

    public function getNumberOfStaffs()
    {
        return Staff::count();
    }

    /**
     * @param $id
     * @return mixed
     * @throws CannotChangeAdminStatusException
     * @throws StaffNotFoundException
     */
    public function validateStaff($id): mixed
    {
        return $this->changeStatus($this->getById($id));
    }

    /**
     * @param $staff
     * @return mixed
     * @throws CannotChangeAdminStatusException
     */
    private function changeStatus($staff): mixed
    {
        $this->canChangeStatus($staff->id);
        if ($staff->user->verified_at == 0) {
            $staff->user->verified_at = 1;
        } else {
            $staff->user->verified_at = 0;
        }
        $staff->user->save();
        return $staff;
    }


    /**
     * @param $id
     * @return void
     * @throws CannotChangeAdminStatusException
     */
    private function canChangeStatus($id): void
    {
        if ($id == AdminInfo::AdminInfo['id']) {
            throw new CannotChangeAdminStatusException();
        }
    }


    /**
     * @param $id
     * @return void
     * @throws CannotDeleteAdminException
     * @throws CannotDeleteStaffException
     */
    private function canBeDeleted($id): void
    {
        if ($id == AdminInfo::AdminInfo['id']) {
            throw new CannotDeleteAdminException();
        }
        if ($id == $this->authService->getCurrentUser()) {
            throw new CannotDeleteStaffException();
        };
    }
}

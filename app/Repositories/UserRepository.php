<?php

namespace App\Repositories;

use App\Constants\RolesType;
use App\Exceptions\Staff\CannotDeleteAdminException;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::paginate(10);
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function getByUserId($id)
    {
        return User::find($id);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserByPassword($loginUserData, $user): bool
    {
        return Hash::check($loginUserData['password'], $user->password);
    }

    public function create($user)
    {
        return User::create($user);
    }


    public function update($request, $id)
    {
        $user = User::find($id);
        return $user->update($request->all());
    }


    /**
     * @param $request
     * @return Authenticatable|null
     */
    public function editConnectedUser($request)
    {
        $data = $request->all();
        $user = auth('api')->user();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->fill($data);
        $user->save();
        return $user;
    }


    public function changePassword($user, $password)
    {
        $user->password = Hash::make($password);
        return $user->update();
    }

    public function validateMail($user)
    {
        $user->email_verified_at = Carbon::now();
        return $user->update();
    }


    /**
     * @param $id
     * @return bool
     * @throws CannotDeleteAdminException
     */
    public function destroy($id): bool
    {
        $user = $this->getByUserId($id);
        if ($user->role_id == RolesType::RolesType['ADMIN_ROLE']['ID']) {
            throw new CannotDeleteAdminException();
        }
        $user->delete($id);
        return true;
    }

    public function validateUser($user)
    {
        $user = User::find($user);
        $user->verified_at = Carbon::now();
        $user->save();
        return $user;
    }

    public function getCurrentUser()
    {
        return auth('api')->user()->userable_id;
    }
}

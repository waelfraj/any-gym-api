<?php

namespace App\Services;

use App\Constants\RolesType;
use App\Exceptions\TokenExceptions\UnauthorizedException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class RegisterService
{

    /**
     * @param LoginService $loginService
     * @param MemberService $memberService
     * @param CoachService $coachService
     */
    public function __construct(
        private readonly LoginService  $loginService,
        private readonly MemberService $memberService,
        private readonly CoachService  $coachService,
    )
    {
    }


    /**
     * @param $user
     * @return array
     * @throws InternalErrorException
     * @throws UnauthorizedException
     */
    public function register($user): array
    {
        $newUser = [];
        switch ($user->role_id) {
            case RolesType::RolesType['MEMBER_ROLE']['ID']:
                $newUser = $this->memberService->create($user);
                break;
            case RolesType::RolesType['COACH_ROLE']['ID']:
                $newUser = $this->coachService->create($user);
                break;
            default:
                break;
        }

        if ($newUser) {
            return $this->loginService->login($user);

        }
        throw new InternalErrorException();
    }
}

<?php

namespace App\Services;

class HomeStaffService
{
    public function __construct(
        private readonly StaffService  $staffService,
        private readonly MemberService $memberService,
        private readonly CoachService  $coachService
    )
    {
    }

    /**
     * @return array
     */
    public function home(): array
    {
        return [
            'nbrMembers' => $this->memberService->getNumberOfMembers(),
            'nbrStaffs' => $this->staffService->getNumberOfStaffs(),
            'nbrCoaches' => $this->coachService->getNumberOfCoaches(),
            'coaches' => $this->coachService->getLastThree(),
            'members' => $this->memberService->getLastThree(),
        ];
    }
}

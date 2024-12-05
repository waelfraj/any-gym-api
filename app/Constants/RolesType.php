<?php
namespace App\Constants;

class RolesType
{
    const RolesType = [
        'ADMIN_ROLE' => [
            'ID' => 1,
            'NAME' => 'admin',
        ],
        'STAFF_ROLE' => [
            'ID' => 2,
            'NAME' => 'staff',
        ],

        'COACH_ROLE' => [
            'ID' => 3,
            'NAME' => 'coach',
        ],
        'MEMBER_ROLE' => [
            'ID' => 4,
            'NAME' => 'member',
        ],
    ];
}

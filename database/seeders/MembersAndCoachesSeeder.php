<?php

namespace Database\Seeders;

use App\Constants\RolesType;
use App\Models\Coach;
use App\Models\Member;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MembersAndCoachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $user = Member::create([
                'objective_id' => rand(1, 5),
                'height' => 170 + $i,
                'target_weight' => 70 + $i,
            ])->user()->create([
                'name' => 'Member ' . $i,
                'gender' => 'm',
                'email' => 'member' . $i . '@example.com',
                'address' => 'Rue ' . $i . ' Monastir',
                'password' => Hash::make('password'),
                'role_id' => RolesType::RolesType['MEMBER_ROLE']['ID'],
                'email_verified_at' => Carbon::now()
            ]);
        }
        for ($i = 1; $i <= 15; $i++) {
            $user = Coach::create()->user()->create([
                'name' => 'Coach ' . $i,
                'gender' => 'm',
                'email' => 'coach' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => RolesType::RolesType['COACH_ROLE']['ID'],
                'email_verified_at' => Carbon::now()
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            $user = Staff::create()->user()->create([
                'name' => 'Staff ' . $i,
                'email' => 'Staff' . $i . '@example.com',
                'gender' => 'm',
                'password' => Hash::make('password'),
                'role_id' => RolesType::RolesType['STAFF_ROLE']['ID'],
                'email_verified_at' => Carbon::now()
            ]);
        }
    }
}

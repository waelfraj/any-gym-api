<?php

namespace Database\Seeders;

use App\Constants\AdminInfo;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create()->user()->create([
            'name' => AdminInfo::AdminInfo['name'],
            'email' => AdminInfo::AdminInfo['email'],
            'password' => Hash::make(AdminInfo::AdminInfo['password']),
            'role_id' => AdminInfo::AdminInfo['role'],
            'verified_at'=> true,
            'email_verified_at'=> Carbon::now()
        ]);
    }
}

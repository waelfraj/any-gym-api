<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Constants\RolesType;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RolesType::RolesType as $key => $value){
            DB::table('roles')->insert([
                'name' => $value['NAME'],
                'id' => $value['ID'],
            ]);
        }
    }
}

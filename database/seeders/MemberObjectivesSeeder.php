<?php

namespace Database\Seeders;

use App\Constants\MemberObjectivesData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberObjectivesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (MemberObjectivesData::data as $key => $value){
            DB::table('member_objectives')->insert([
                'id' => $value['id'],
                'name' => $value['name']
            ]);
        }
    }
}

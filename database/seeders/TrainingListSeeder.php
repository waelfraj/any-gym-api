<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\TrainingList;
use Illuminate\Database\Seeder;

class TrainingListSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $trainingList = TrainingList::create([
                'coach_id' => rand(1, 3),
                'title' => 'Training List ' . $i,
                'image' => "https://cdn.pixabay.com/photo/2017/08/07/14/02/man-2604149_1280.jpg",
                'description' => 'Description for Training List ' . $i,
                'is_reserved' => rand(0, 1),
                'total_calories' => rand(300, 400),
            ]);

            $exercises = Exercise::inRandomOrder()->limit(5)->get();
            $trainingList->exercises()->attach($exercises);
        }
    }
}

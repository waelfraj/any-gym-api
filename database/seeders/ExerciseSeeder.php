<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Exercise::create([
                'title' => 'Exercise ' . $i,
                'description' => 'Description of exercise ' . $i,
                'image' => 'https://example.com/image' . $i . '.jpg',
                'difficulty' => 'medium',
                'category' => 'cardio',
                'calories' => 100 * $i,
                'sets' => 3,
            ]);
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|url|string|max:255',
            'difficulty' => 'required|string|in:easy,medium,hard',
            'category' => 'required|string|in:cardio,abs-obliques,biceps,triceps,biceps,shoulders,chest,back,legs',
            'calories' => 'nullable|integer|min:0',
            'sets' => 'nullable|integer|min:0',
        ];
    }
}

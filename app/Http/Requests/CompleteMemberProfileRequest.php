<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteMemberProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'objective_id' => 'integer|min:1|max:5',
            'age' => 'integer|min:10|max:100',
            'height' => 'integer|min:140|max:220',
            'target_weight' => 'integer|min:10|max:200',
            'physical_activity_level' => 'string|in:advanced,intermediate,beginner',
        ];
    }
}

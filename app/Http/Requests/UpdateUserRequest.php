<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|string|email|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|min:8',
            'phone' => 'nullable|integer|min:20000000|max:99999999',
            'address' => 'nullable|string',
            'genre' => 'nullable|string|in:m,f',
        ];
    }
}


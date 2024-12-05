<?php

namespace App\Http\Requests;

use App\Constants\ConstResetPassword;
use Illuminate\Foundation\Http\FormRequest;

class CheckResetPasswordTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required|int|min:'.ConstResetPassword::min.'|max:'.ConstResetPassword::max.'|exists:password_reset_tokens,token',
        ];
    }
}

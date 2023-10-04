<?php

namespace App\Http\Requests;

use App\Enums\UserTags;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', Rule::unique('users', 'email')->ignore($this->id)],
            'login' => ['required', 'string', Rule::unique('users', 'login')->ignore($this->id)],
            'usertag' => ['required', new Enum(UserTags::class)],
            'password' => ['required', 'confirmed'],
        ];
    }
}

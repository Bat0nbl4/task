<?php

namespace App\Http\Requests;

use App\Enums\Enums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BookRequest extends FormRequest
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
            'publisher' => ['required'],
            'author' => ['required'],
            'title' => ['required', Rule::unique('books', 'title')->ignore($this->id)],
            'genre' => ['required'],
            'edition' => ['required', new Enum(Enums::class)],
            'description' => ['sometimes'],
            'file' => ['sometimes', 'file', 'image'],
        ];
    }
}

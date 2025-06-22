<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => [
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($this->book),
            ],
            'total_copies'  => 'required|integer|min:1',
            'description'   => 'nullable|string',
            'cover_image'   => 'nullable|image|max:2048',
            'is_active'     => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'ISBN sudah digunakan.',
        ];
    }
}

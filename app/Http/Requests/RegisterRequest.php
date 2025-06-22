<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|digits:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.digits' => 'Password harus 8 digit.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}

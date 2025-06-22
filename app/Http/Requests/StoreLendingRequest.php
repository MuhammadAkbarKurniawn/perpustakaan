<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLendingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_at'  => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Buku wajib dipilih.',
            'book_id.exists'   => 'Buku tidak valid.',
            'user_id.required' => 'User wajib dipilih.',
            'user_id.exists'   => 'User tidak valid.',
            'due_at.required'  => 'Tanggal jatuh tempo wajib diisi.',
            'due_at.date'      => 'Format tanggal tidak valid.',
            'due_at.after_or_equal' => 'Tanggal pengembalian minimal hari ini.',
        ];
    }
}

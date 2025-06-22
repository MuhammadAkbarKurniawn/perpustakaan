<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'isbn'          => 'required|string|max:20|unique:books,isbn',
            'total_copies'  => 'required|integer|min:1',
            'description'   => 'nullable|string',
            'cover_image'   => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Judul buku wajib diisi.',
            'author.required'       => 'Penulis wajib diisi.',
            'isbn.required'         => 'ISBN wajib diisi.',
            'isbn.unique'           => 'ISBN sudah terdaftar.',
            'total_copies.required' => 'Jumlah salinan wajib diisi.',
            'cover_image.image'     => 'File harus berupa gambar.',
            'cover_image.max'       => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}

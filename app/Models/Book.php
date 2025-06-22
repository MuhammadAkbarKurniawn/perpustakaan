<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'total_copies',
        'available_copies',
        'description',
        'cover_image',
        'is_active',
    ];

    public function lendingRecords()
    {
        return $this->hasMany(LendingRecord::class);
    }
}

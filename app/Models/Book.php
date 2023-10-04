<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Enums;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'title',
        'publisher',
        'genre',
        'description',
        'edition',
        'image',
    ];

    protected $casts = [
        'edition' => Enums::class
    ];
}

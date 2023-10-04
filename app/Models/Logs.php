<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Enums;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
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

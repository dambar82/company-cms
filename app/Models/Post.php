<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'images',
        'documents',
        'audios',
        'videos'
    ];

    protected $casts = [
        'images' => 'array',
        'documents' => 'array',
        'audios' => 'array',
        'videos' => 'array'
    ];
}

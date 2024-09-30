<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AminaNews extends Model
{
    use HasFactory;

    protected $table = 'amina_news';

    protected $fillable = [
        'title',
        'content',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];
}

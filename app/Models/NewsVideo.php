<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'video',
        'description',
        'link'
    ];
}

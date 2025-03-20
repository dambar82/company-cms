<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'text',
        'image',
        'video',
        'link'
    ];

    public function news()
    {
        return $this->hasOne(News::class);
    }
}

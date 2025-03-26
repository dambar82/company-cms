<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NewsContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'position',
        'text',
        'image',
        'video',
        'link'
    ];

    public function news(): HasOne
    {
        return $this->hasOne(News::class);
    }
}

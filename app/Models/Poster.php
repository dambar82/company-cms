<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = [
        'title_rus',
        'poster_rus',
        'title_tat',
        'poster_tat'
    ];
}

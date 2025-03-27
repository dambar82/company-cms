<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AminaSong extends Model
{
    protected $fillable = [
        'id',
        'title',
        'content',
        'image',
        'active'
    ];
}

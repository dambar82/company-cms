<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AminaFeedback extends Model
{
    protected $fillable = [
        'creator' ,
        'organization',
        'job_title',
        'region',
        'fio',
        'email',
        'text',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];
}

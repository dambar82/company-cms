<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AminaFeedback extends Model
{
    protected $fillable = [
        'creator' ,
        'job_title',
        'region',
        'fio',
        'email',
        'text',
        'image'
    ];
}

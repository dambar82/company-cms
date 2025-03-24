<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AminaFeedback extends Model
{
    protected $fillable = [
        'text',
        'image',
        'organization',
        'private_person'
    ];
}

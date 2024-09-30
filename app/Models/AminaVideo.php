<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AminaVideo extends Model
{
    use HasFactory;

    protected $table = 'amina_videos';

    protected $fillable = [
        'title',
        'path',
        'preview'
    ];
}

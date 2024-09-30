<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AminaAudio extends Model
{
    use HasFactory;

    protected $table = 'amina_audios';

    protected $fillable = [
        'title',
        'path'
    ];
}

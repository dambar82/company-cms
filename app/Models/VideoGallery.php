<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $table = 'video_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'title',
        'video',
    ];

    protected $guarded = array();
}

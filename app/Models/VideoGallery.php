<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VideoGallery extends Model
{
    protected $table = 'video_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'project_id',
        'name',
        'title',
        'preview',
        'video',
    ];

    protected $guarded = array();

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}

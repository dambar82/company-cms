<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ImageGallery extends Model
{
    protected $table = 'image_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'project_id',
        'name',
        'title',
        'caption',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'image_gallery_project');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    protected $table = 'image_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'title',
        'caption',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    protected $guarded = array();
}

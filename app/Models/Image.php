<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'image',
        'image_galleries_id',
        'description'
    ];

    protected $guarded = array();
}

<?php

namespace App\Models\MDT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'category_id',
        'description',
        'image',
        'preview',
        'video'
    ];
}

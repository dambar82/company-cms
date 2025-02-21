<?php

namespace App\Models\MDT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_content_id',
        'name',
        'description',
        'image'
    ];
}

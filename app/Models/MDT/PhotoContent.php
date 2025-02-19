<?php

namespace App\Models\MDT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'category_id',
        'description',
        'photo'
    ];
}

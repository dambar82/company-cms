<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadImage extends Model
{
    use HasFactory;

    protected $table = 'lead_image';

    protected $fillable = [
        'lead_id',
        'image',
        'description'
    ];
}

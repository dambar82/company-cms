<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadVideo extends Model
{
    use HasFactory;

    protected $table = 'lead_video';

    protected $fillable = [
        'lead_id',
        'video',
        'description'
    ];
}

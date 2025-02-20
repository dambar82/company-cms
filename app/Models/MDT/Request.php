<?php

namespace App\Models\MDT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'name',
        'surname',
        'phone',
        'email',
        'budget',
        'service',
        'description'
    ];
}

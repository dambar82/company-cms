<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios';

    protected $fillable = [
        'project_id',
        'title',
        'path'
    ];

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}

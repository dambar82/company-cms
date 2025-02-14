<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'lead';

    protected $fillable = [
        'title',
        'content',
        'image',
        'video',
        'date',
        'is_active'
    ];

    public function contents()
    {
        return $this->hasMany(LeadContent::class);
    }

    public  function images()
    {
        return $this->hasMany(LeadImage::class);
    }

    public function videos()
    {
        return $this->hasMany(LeadVideo::class);
    }
}

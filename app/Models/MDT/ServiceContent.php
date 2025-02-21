<?php

namespace App\Models\MDT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceContentImage::class);
    }
}

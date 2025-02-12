<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $video_gallery_id
 * @property string $description
 * @property string|null $video
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Video newModelQuery()
 * @method static Builder|Video newQuery()
 * @method static Builder|Video query()
 * @method static Builder|Video whereCreatedAt($value)
 * @method static Builder|Video whereDescription($value)
 * @method static Builder|Video whereId($value)
 * @method static Builder|Video whereUpdatedAt($value)
 * @method static Builder|Video whereVideo($value)
 * @method static Builder|Video whereVideoGalleryId($value)
 * @mixin Eloquent
 */
class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_gallery_id',
        'description',
        'video'
    ];
}

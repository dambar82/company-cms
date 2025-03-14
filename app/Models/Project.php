<?php

namespace App\Models;

use App\Models\Quiz\Quiz;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'news_project');
    }

    public function video_galleries(): BelongsToMany
    {
        return $this->belongsToMany(VideoGallery::class, 'video_gallery_project');
    }

    public function image_galleries(): BelongsToMany
    {
        return $this->belongsToMany(ImageGallery::class, 'image_gallery_project');
    }

    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(Banner::class, 'banner_project');
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_project');
    }
}

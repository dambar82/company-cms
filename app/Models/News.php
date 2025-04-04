<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property array|null $images
 * @property string|null $date
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Project|null $project
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @method static Builder|News newModelQuery()
 * @method static Builder|News newQuery()
 * @method static Builder|News query()
 * @method static Builder|News whereActive($value)
 * @method static Builder|News whereContent($value)
 * @method static Builder|News whereCreatedAt($value)
 * @method static Builder|News whereDate($value)
 * @method static Builder|News whereId($value)
 * @method static Builder|News whereImages($value)
 * @method static Builder|News whereTitle($value)
 * @method static Builder|News whereUpdatedAt($value)
 * @mixin Eloquent
 */
class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'meta_description',
        'slug',
        'date',
        'active',
        'project'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'news_project');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(NewsContent::class);
    }

    protected static function booted(): void
    {
        static::created(function (News $news) {
            if ($news->project != null) {
                DB::table('news_project')->insert([
                    'news_id' => $news->id,
                    'project_id' => $news->project,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}

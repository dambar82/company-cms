<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property string $name
 * @property string $title
 * @property string|null $preview
 * @property string|null $video
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Project|null $project
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @property-read Collection<int, Video> $videos
 * @property-read int|null $videos_count
 * @method static Builder|VideoGallery newModelQuery()
 * @method static Builder|VideoGallery newQuery()
 * @method static Builder|VideoGallery query()
 * @method static Builder|VideoGallery whereCreatedAt($value)
 * @method static Builder|VideoGallery whereId($value)
 * @method static Builder|VideoGallery whereName($value)
 * @method static Builder|VideoGallery wherePreview($value)
 * @method static Builder|VideoGallery whereTitle($value)
 * @method static Builder|VideoGallery whereUpdatedAt($value)
 * @method static Builder|VideoGallery whereVideo($value)
 * @mixin Eloquent
 */
class VideoGallery extends Model
{
    protected $table = 'video_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'title',
        'preview',
        'video',
        'link',
        'is_published',
        'project'
    ];

    protected $guarded = array();

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'video_gallery_project');
    }

    protected static function booted(): void
    {
        static::created(function (VideoGallery $videoGallery) {
            DB::table('video_gallery_project')->insert([
                'video_gallery_id' => $videoGallery->id,
                'project_id' => $videoGallery->project,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}

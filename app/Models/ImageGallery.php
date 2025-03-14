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
use Illuminate\Support\Facades\Log;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $caption
 * @property-read Collection<int, Image> $images
 * @property-read int|null $images_count
 * @property-read Project|null $project
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @method static Builder|ImageGallery newModelQuery()
 * @method static Builder|ImageGallery newQuery()
 * @method static Builder|ImageGallery query()
 * @method static Builder|ImageGallery whereCaption($value)
 * @method static Builder|ImageGallery whereCreatedAt($value)
 * @method static Builder|ImageGallery whereId($value)
 * @method static Builder|ImageGallery whereName($value)
 * @method static Builder|ImageGallery whereTitle($value)
 * @method static Builder|ImageGallery whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ImageGallery extends Model
{
    protected $table = 'image_galleries';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'title',
        'caption',
        'project'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'image_gallery_project');
    }

    protected static function booted(): void
    {
        static::created(function (ImageGallery $imageGallery) {
            DB::table('image_gallery_project')->insert([
                'image_gallery_id' => $imageGallery->id,
                'project_id' => $imageGallery->project,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        });
    }
}

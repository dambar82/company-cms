<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string|null $title
 * @property string $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Project|null $project
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @method static Builder|Audio newModelQuery()
 * @method static Builder|Audio newQuery()
 * @method static Builder|Audio query()
 * @method static Builder|Audio whereCreatedAt($value)
 * @method static Builder|Audio whereId($value)
 * @method static Builder|Audio wherePath($value)
 * @method static Builder|Audio whereTitle($value)
 * @method static Builder|Audio whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios';

    protected $fillable = [
        'title',
        'path'
    ];

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'audio_project');
    }
}

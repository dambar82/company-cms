<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @method static Builder|Quiz newModelQuery()
 * @method static Builder|Quiz newQuery()
 * @method static Builder|Quiz query()
 * @method static Builder|Quiz whereCreatedAt($value)
 * @method static Builder|Quiz whereId($value)
 * @method static Builder|Quiz whereImage($value)
 * @method static Builder|Quiz whereName($value)
 * @method static Builder|Quiz whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'quiz_project');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id', 'id');
    }
}

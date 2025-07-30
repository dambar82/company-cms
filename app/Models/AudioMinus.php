<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string|null $title
 * @property string $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|AudioMinus newModelQuery()
 * @method static Builder<static>|AudioMinus newQuery()
 * @method static Builder<static>|AudioMinus query()
 * @method static Builder<static>|AudioMinus whereCreatedAt($value)
 * @method static Builder<static>|AudioMinus whereId($value)
 * @method static Builder<static>|AudioMinus wherePath($value)
 * @method static Builder<static>|AudioMinus whereTitle($value)
 * @method static Builder<static>|AudioMinus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AudioMinus extends Model
{
    protected $fillable = [
        'title',
        'path'
    ];
}

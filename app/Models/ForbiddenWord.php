<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property string $word
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ForbiddenWord newModelQuery()
 * @method static Builder|ForbiddenWord newQuery()
 * @method static Builder|ForbiddenWord query()
 * @method static Builder|ForbiddenWord whereCreatedAt($value)
 * @method static Builder|ForbiddenWord whereId($value)
 * @method static Builder|ForbiddenWord whereUpdatedAt($value)
 * @method static Builder|ForbiddenWord whereWord($value)
 * @mixin Eloquent
 */
class ForbiddenWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word'
    ];
}

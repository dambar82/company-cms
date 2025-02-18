<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $client_id
 * @property int $quiz_id
 * @property int $result
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Quiz $quiz
 * @method static Builder|Result newModelQuery()
 * @method static Builder|Result newQuery()
 * @method static Builder|Result query()
 * @method static Builder|Result whereClientId($value)
 * @method static Builder|Result whereCreatedAt($value)
 * @method static Builder|Result whereId($value)
 * @method static Builder|Result whereQuizId($value)
 * @method static Builder|Result whereResult($value)
 * @method static Builder|Result whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'quiz_id',
        'result'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }
}

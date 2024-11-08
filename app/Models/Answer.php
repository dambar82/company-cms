<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $question_id
 * @property string $text_answer
 * @property int $correct_answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Question|null $question
 * @method static Builder|Answer newModelQuery()
 * @method static Builder|Answer newQuery()
 * @method static Builder|Answer query()
 * @method static Builder|Answer whereCorrectAnswer($value)
 * @method static Builder|Answer whereCreatedAt($value)
 * @method static Builder|Answer whereId($value)
 * @method static Builder|Answer whereQuestionId($value)
 * @method static Builder|Answer whereTextAnswer($value)
 * @method static Builder|Answer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, boolean>
     */
    protected $fillable = [
        'question_id',
        'answer',
        'correct_answer'
    ];

    public function question(): HasOne
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}

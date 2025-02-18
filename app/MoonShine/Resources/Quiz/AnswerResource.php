<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Answer>
 */
class AnswerResource extends ModelResource
{
    protected string $model = Answer::class;

    protected string $title = 'Answers';

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('', 'answer')->placeholder('Добавьте ответ'),
                Checkbox::make('Ответ верный', 'correct_answer')
            ]),
        ];
    }

    /**
     * @param Answer $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}

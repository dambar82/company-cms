<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Question>
 */
class QuestionResource extends ModelResource
{
    protected string $model = Question::class;

    protected string $title = 'Вопросы';

    public string $column = 'name';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Вопрос', 'question'),
                        Image::make('Картинка', 'image')
                            ->dir('questions')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ])
                ])->columnSpan(8),
                Column::make([
                    Select::make('Викторина', 'quiz_id')
                        ->options(Quiz::pluck('name', 'id')->toArray())
                ])->columnSpan(4)
            ]),
            Divider::make(),
            Block::make([
                Json::make('Ответы', 'answer')
                    ->hideOnIndex()
                    ->asRelation(new AnswerResource())
                    ->fields([
                        Text::make('Ответ', 'answer')->placeholder('Добавьте текст с ответом'),
                        Checkbox::make('Ответ верный', 'correct_answer')
                    ])
                    ->creatable()
                    ->removable()
            ])
        ];
    }

    /**
     * @param Question $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}

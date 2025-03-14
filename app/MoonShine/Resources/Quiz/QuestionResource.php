<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Question;
use App\Models\Quiz;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Question>
 */
class QuestionResource extends ModelResource
{
    protected string $model = Question::class;

    protected string $title = 'Вопросы';

    public string $column = 'name';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Вопрос', 'question'),
            Image::make('Картинка', 'image'),
            Select::make('Викторина', 'quiz_id')
                ->options(Quiz::pluck('name', 'id')->toArray())
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        $fields = [
            Box::make([
                ID::make(),
                Grid::make([
                    Column::make([
                        Box::make([
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
                ])
            ])
        ];

        if ($this->getItem()) {
            $fields = array_merge($fields, [
                Divider::make(),
                Box::make([
                    RelationRepeater::make(
                        'Ответы',
                        'answer',
                        resource: AnswerResource::class)
                        ->fields([
                            Text::make('Ответ', 'answer')->placeholder('Добавьте текст с ответом'),
                            Checkbox::make('Ответ верный', 'correct_answer')
                        ])
                        ->creatable()
                        ->removable()
                ])

            ]);
        }

        return $fields;
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Вопрос', 'question'),
            Image::make('Картинка', 'image'),
            Select::make('Викторина', 'quiz_id')
                ->options(Quiz::pluck('name', 'id')->toArray()),
            RelationRepeater::make(
                'Ответы',
                'answer',
                resource: AnswerResource::class)
                ->fields([
                    Text::make('Ответ', 'answer')->placeholder('Добавьте текст с ответом'),
                    Checkbox::make('Ответ верный', 'correct_answer')
                ])
        ];
    }

    /**
     * @param Question $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Quiz\Quiz;
use App\MoonShine\Resources\ProjectResource;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Quiz>
 */
class QuizResource extends ModelResource
{
    protected string $model = Quiz::class;

    protected string $title = 'Викторины';

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
            Text::make('Название', 'name'),
            Image::make('Картинка', 'image'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Grid::make([
                    Column::make([
                        Box::make([
                            Text::make('Название', 'name'),
                            Image::make('Картинка', 'image')
                                ->dir('quiz')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                                ->required()
                        ])
                    ])->columnSpan(4)
                ])
            ])
        ];
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Image::make('Картинка', 'image'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true),
            RelationRepeater::make(
                'Вопросы',
                'questions',
                resource: QuestionResource::class)
                ->fields([
                    Text::make('Вопрос', 'question'),
                    Image::make('Картинка', 'image')
                ])
        ];
    }

    /**
     * @param Quiz $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

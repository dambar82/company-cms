<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\Result;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Result>
 */
class ResultResource extends ModelResource
{
    protected string $model = Result::class;

    protected string $title = 'Результаты';

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
            Select::make('Викторина', 'quiz_id')
                ->options(
                    Quiz::pluck('name', 'id')->toArray()
                ),
            Text::make('Рузультат', 'result')
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
                            Select::make('Викторина', 'quiz_id')
                                ->options(
                                    Quiz::pluck('name', 'id')->toArray()
                                )
                        ])
                    ])->columnSpan(6),
                    Column::make([
                        Box::make([
                            Text::make('Рузультат', 'result')
                        ])
                    ])->columnSpan(6),
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
            ID::make(),
            Select::make('Викторина', 'quiz_id')
                ->options(
                    Quiz::pluck('name', 'id')->toArray()
                ),
            Text::make('Рузультат', 'result')
        ];
    }

    /**
     * @param Result $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Service;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Service>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Услуги МЦТ';

    protected string $column = 'name';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Slug::make('Slug')
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        $fields = [
            ID::make(),
            Box::make([
                Grid::make([
                    Column::make([
                        Box::make([
                            Text::make('Название', 'name')
                                ->required()
                                ->reactive(),
                        ])
                    ])->columnSpan(6),
                    Column::make([
                        Box::make([
                            Slug::make('Slug')
                                ->from('name')
                                ->live()
                                ->required()
                                ->locked()
                                ->separator('_'),
                        ])
                    ])->columnSpan(6)
                ])
            ])
        ];

        if ($this->isUpdateFormPage()) {
            $fields = array_merge($fields, [
                LineBreak::make(),
                Box::make([
                    Collapse::make('Добавить категорию', [
                        RelationRepeater::make(
                            'Категории',
                            'category',
                            resource: CategoryResource::class)
                            ->fields([
                                Column::make([
                                    Box::make([
                                        ID::make(),
                                        Text::make('Название', 'name')->required()
                                    ]),
                                ])->columnSpan(6),
                                Column::make([
                                    Box::make([
                                        Text::make('Slug')->required()->locked()
                                    ])
                                ])->columnSpan(6)
                            ])
                            ->creatable()
                            ->removable()
                    ])
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
            Text::make('Название', 'name'),
            Slug::make('Slug'),
            RelationRepeater::make(
                'Категории',
                'category',
                resource: CategoryResource::class)
                ->fields([
                    ID::make(),
                    Column::make([
                        Box::make([
                            Text::make('Название', 'name')->required()
                        ]),
                    ])->columnSpan(6),
                    Column::make([
                        Box::make([
                            Text::make('Slug')->required()->locked()
                        ])
                    ])->columnSpan(6)
                ])
        ];
    }

    /**
     * @param Service $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

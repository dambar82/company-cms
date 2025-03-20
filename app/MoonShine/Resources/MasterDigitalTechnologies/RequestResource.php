<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Request;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<Request>
 */
class RequestResource extends ModelResource
{
    protected bool $stickyTable = true;

    protected string $model = Request::class;

    protected string $title = 'Заявки';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::DETAIL;

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name')->readonly(),
            Text::make('Фамилия', 'surname')->readonly(),
            Text::make('Компания', 'company')->readonly(),
            Text::make('Услуга', 'service')->readonly()
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
                            ID::make()->sortable(),
                            Text::make('Имя', 'name')->readonly(),
                            Text::make('Фамилия', 'surname')->readonly(),
                            Text::make('Телефон', 'phone')->readonly()->copy(),
                            Text::make('Почта', 'email')->readonly()->copy(),

                        ])
                    ])->columnSpan(6),
                    Column::make([
                        Box::make([
                            Text::make('Компания', 'company')->readonly(),
                            Text::make('Примерный бюджет', 'budget')->readonly(),
                            Text::make('Услуга', 'service')->readonly(),
                            Textarea::make('Описание', 'description')->readonly(),
                        ])
                    ])->columnSpan(6)
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
            Text::make('Имя', 'name')->readonly(),
            Text::make('Фамилия', 'surname')->readonly(),
            Text::make('Телефон', 'phone')->readonly()->copy(),
            Text::make('Почта', 'email')->readonly()->copy(),
            Text::make('Компания', 'company')->readonly(),
            Text::make('Примерный бюджет', 'budget')->readonly(),
            Text::make('Услуга', 'service')->readonly(),
            Textarea::make('Описание', 'description')->readonly(),
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(
        Action::UPDATE,
            Action::CREATE,
            Action::DELETE,
            Action::MASS_DELETE
        );
    }
}

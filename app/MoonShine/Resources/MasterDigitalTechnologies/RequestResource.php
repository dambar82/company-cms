<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Request;
use Illuminate\Database\Eloquent\Model;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Exceptions\FieldException;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Request>
 */
class RequestResource extends ModelResource
{
    protected string $model = Request::class;

    protected string $title = 'Заявки';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     * @throws FieldException
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        ID::make()->sortable()->hideOnIndex(),
                        Text::make('Имя', 'name')->readonly(),
                        Text::make('Фамилия', 'surname')->readonly(),
                        Text::make('Телефон', 'phone')->readonly()->copy(),
                        Text::make('Почта', 'email')->readonly()->copy(),

                    ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Text::make('Компания', 'company')->readonly(),
                        Text::make('Примерный бюджет', 'budget')->readonly(),
                        Text::make('Услуга', 'service')->readonly(),
                        Textarea::make('Описание', 'description')->hideOnIndex()->readonly(),
                    ])
                ])->columnSpan(6)
            ])
        ];
    }

    /**
     * @param Request $item
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

    public function getActiveActions(): array
    {
        return ['view', 'update'];
    }
}

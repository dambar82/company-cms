<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\ImageGallery;
use App\Models\MDT\Service;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Json;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<ImageGallery>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Услуги МЦТ';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'name')->required(),
                    ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Text::make('Slug')->required(),
                    ])
                ])->columnSpan(6)
            ]),
            Divider::make(),
            Block::make([
                Collapse::make('Добавить категорию', [
                    Json::make('Категории', 'category')
                        ->hideOnIndex()
                        ->asRelation(new CategoryResource())
                        ->fields([
                            Column::make([
                                Block::make([
                                    Text::make('Название', 'name')->required()
                                ]),
                            ])
                                ->columnSpan(6),
                            Column::make([
                                Block::make([
                                    Text::make('Slug')->hideOnIndex()->required()
                                ])
                            ])
                                ->columnSpan(6)
                        ])
                        ->creatable()
                        ->removable()
                    ])
                ])

        ];
    }

    /**
     * @param Service $item
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

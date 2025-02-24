<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\ImageGallery;
use App\Models\MDT\Service;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Json;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Throwable;

/**
 * @extends ModelResource<ImageGallery>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Услуги МЦТ';

    protected string $column = 'name';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return array
     * @throws Throwable
     */
    public function fields(): array
    {
        $fields = [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'name')
                            ->required()
                            ->reactive(),
                    ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Slug::make('Slug')
                            ->from('name')
                            ->live()
                            ->required()
                            ->locked()
                            ->separator('_'),
                    ])
                ])->columnSpan(6)
            ]),
        ];

        if ($this->getItemID()) {
                $fields = array_merge($fields, [
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
                                        Text::make('Slug')->required()->locked()
                                    ])
                                ])
                                    ->columnSpan(6)
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Category;
use App\Models\MDT\PhotoContent;
use App\Models\MDT\Service;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<PhotoContent>
 */
class PhotoContentResource extends ModelResource
{
    protected string $model = PhotoContent::class;

    protected string $title = 'Фото';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Grid::make([
                ID::make()->sortable()->hideOnIndex(),
                Column::make([
                    Block::make([
                        Image::make('Фото', 'photo')
                        ->dir('mdt/photos')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable()
                        ->required(),
                        TinyMce::make('Описание', 'description')
                            ->hideOnIndex(),
                    ]),
                ])
                ->columnSpan(8),
                Column::make([
                    Block::make([
                        Select::make('Услуга', 'service_id')
                            ->options(
                                Service::pluck('name', 'id')->toArray()
                            )
                        ->required(),
                        Divider::make(),
                        Select::make('Категория', 'category_id')
                            ->options(
                                Category::pluck('name', 'id')->toArray()
                            )
                        ->required()
                    ])
                ])
                ->columnSpan(4),
            ])
        ];
    }

    /**
     * @param PhotoContent $item
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

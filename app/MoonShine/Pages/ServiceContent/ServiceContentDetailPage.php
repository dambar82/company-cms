<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\MoonShine\Resources\MasterDigitalTechnologies\CategoryResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\File;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Position;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\DetailPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use Throwable;

class ServiceContentDetailPage extends DetailPage
{
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Grid::make([
            ID::make()->sortable()->hideOnIndex(),
            Text::make('Название', 'name')->required(),
            TinyMce::make('Описание', 'description'),
            BelongsTo::make('Услуга', 'Service'),
            BelongsTo::make('Категория', 'category', resource: new CategoryResource()),
            Image::make('Фото', 'image'),
            File::make('Видео', 'video'),
            Image::make('Preview'),
            Json::make('Дополнительные фото', 'images')
                ->asRelation(new ServiceContentImageResource())
                ->vertical()
                ->fields([
                    Grid::make([
                        Position::make(),
                        Image::make('Фото', 'image'),
                        Text::make('Название', 'name'),
                        TinyMce::make('Описание', 'description')
                    ])
                ])
            ])
        ];
    }
}

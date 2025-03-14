<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;
use Throwable;


class ServiceContentDetailPage extends DetailPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name')->required(),
            TinyMce::make('Описание', 'description'),
            Image::make('Основное фото', 'image'),
            File::make('Видео', 'video'),
            Url::make('Ссылка на видео','link')->blank(),
            Image::make('Preview'),
            RelationRepeater::make(
                'Фотографии',
                'images',
                resource: ServiceContentImageResource::class)
                ->vertical()
                ->fields([
                    Box::make([
                        ID::make(),
                        Position::make(),
                        Image::make('Фото', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('mdt/images')
                            ->removable(),
                        Text::make('Название', 'name')
                            ->placeholder('Добавьте название'),
                        TinyMce::make('Описание', 'description')
                    ])
                ])
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

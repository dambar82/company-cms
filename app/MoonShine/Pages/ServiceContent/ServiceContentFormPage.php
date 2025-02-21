<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\MoonShine\Resources\MasterDigitalTechnologies\CategoryResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\File;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Position;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;

class ServiceContentFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        if (!$this->getResource()->getItem()) {
            return [
                Grid::make([
                    ID::make()->sortable()->hideOnIndex(),
                    Column::make([
                        Block::make([
                            Text::make('Название', 'name')->required(),
                            TinyMce::make('Описание', 'description')
                                ->hideOnIndex(),
                            File::make('Видео', 'video')
                                ->dir('mdt/video/videos')
                                ->allowedExtensions(['mp4'])
                                ->removable()
                                ->disableDownload(),
                            Image::make('Preview')
                                ->dir('mdt/video/preview')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable()
                        ]),
                    ])
                        ->columnSpan(8),
                    Column::make([
                        Block::make([
                            BelongsTo::make('Услуга', 'Service')
                                ->required(),
                            Divider::make(),
                            BelongsTo::make('Категория', 'category', resource: new CategoryResource())
                                ->required(),
                        ]),
                        Divider::make(),
                        Block::make([
                            Image::make('Фото', 'image')
                                ->dir('mdt/images')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable()
                                ->required()
                        ])
                    ])
                        ->columnSpan(4),
                ])
            ];
        }

        return [
            Grid::make([
                ID::make()->sortable()->hideOnIndex(),
                Column::make([
                    Block::make([
                        Text::make('Название', 'name')->required(),
                        TinyMce::make('Описание', 'description')
                            ->hideOnIndex(),
                        File::make('Видео', 'video')
                            ->dir('mdt/video/videos')
                            ->allowedExtensions(['mp4'])
                            ->removable()
                            ->disableDownload(),
                        Image::make('Preview')
                            ->dir('mdt/video/preview')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable()
                    ]),
                ])
                    ->columnSpan(8),
                Column::make([
                    Block::make([
                        BelongsTo::make('Услуга', 'Service')
                            ->required(),
                        Divider::make(),
                        BelongsTo::make('Категория', 'category', resource: new CategoryResource())
                            ->required(),
                    ]),
                    Divider::make(),
                    Block::make([
                        Image::make('Фото', 'image')
                            ->dir('mdt/images')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable()
                    ])
                ])
                    ->columnSpan(4),
            ]),
            Collapse::make('Добавить фото', [
                    Block::make([
                        Json::make('', 'images')
                            ->asRelation(new ServiceContentImageResource())
                            ->vertical()
                            ->fields([
                                Grid::make([
                                    Column::make([
                                        Block::make([
                                            Position::make(),
                                            Image::make('Фото', 'image')
                                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                                ->dir('lead/images')
                                                ->removable()
                                                ->hideOnIndex(),
                                            Text::make('Название', 'name')
                                                ->hideOnIndex()
                                                ->placeholder('Добавьте название'),
                                            TinyMce::make('Описание', 'description')
                                                ->hideOnIndex(),
                                        ])
                                    ])
                                ])
                            ])->removable()
                    ])
                ])
        ];
    }
}

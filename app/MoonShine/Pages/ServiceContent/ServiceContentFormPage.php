<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Fields;
use MoonShine\Fields\File;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Position;
use MoonShine\Fields\Select;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;

class ServiceContentFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws \Throwable
     */
    public function fields(): array
    {
        $firstFormElement = [
            ID::make()->sortable()->hideOnIndex(),
            Column::make([
                Block::make([
                    Text::make('Название', 'name')->required(),
                ]),
            ])
                ->columnSpan(8),
        ];

        $secondFormElement = [
            Column::make([
                Block::make([
                    Image::make('Фото', 'image')
                        ->dir('mdt/images')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable()
                        ->required()
                ])
            ])
                ->columnSpan(4),
        ];

        $thirdFormElement = [
            Column::make([
                Block::make([
                    Image::make('Фото', 'image')
                        ->dir('mdt/images')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable()
                ])
            ])
                ->columnSpan(4),
        ];

        $fourthFormElement = [
            Column::make([
                Block::make([
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
                    Select::make('Услуга', 'service_id')
                        ->nullable()
                        ->options(Service::query()->get()->pluck('name', 'id')->toArray())
                        ->reactive(function(Fields $fields, ?string $value): Fields {
                            return tap($fields, static fn ($fields) => $fields
                                ->findByColumn('category_id')
                                ?->options(Category::where('service_id', $value)
                                    ->get()
                                    ->pluck('name', 'id')
                                    ->toArray())
                            );
                        })
                        ->required(),
                    Divider::make(),
                    Select::make('Категория', 'category_id')
                        ->nullable()
                        ->options(Category::query()->get()->pluck('name', 'id')->toArray())
                        ->reactive()
                        ->required(),
                ]),
                Divider::make(),
                Block::make([
                    Switcher::make( 'Отобразить в первую очередь', 'Is_first')
                        ->updateOnPreview(),
                ]),
                Divider::make(),
                Block::make([
                    Switcher::make( 'Скрыть', 'hidden')
                        ->updateOnPreview()
                ])
            ])
                ->columnSpan(4),
        ];

        if (!$this->getResource()->getItem()) {
            return [
                Grid::make(
                    array_merge($firstFormElement, $secondFormElement, $fourthFormElement)
                )
            ];
        }

        return [
            Grid::make(
                array_merge($firstFormElement, $thirdFormElement, $fourthFormElement)
            ),
            Divider::make(),
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
                                            ->dir('mdt/images')
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

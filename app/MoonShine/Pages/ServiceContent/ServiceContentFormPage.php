<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;
use Throwable;


class ServiceContentFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $fields = [
            Grid::make([
                ID::make(),
                Column::make([
                    Box::make([
                        Text::make('Название', 'name')->required(),
                        TinyMce::make('Описание', 'description')
                    ])
                ])->columnSpan(8),
                Column::make([
                    Box::make([
                        Select::make('Услуга', 'service_id')
                            ->nullable()
                            ->options(Service::query()->get()->pluck('name', 'id')->toArray())
                            ->reactive(function(FieldsContract  $fields, ?string $value): FieldsContract  {
                                $fields->findByColumn('category_id')
                                    ?->options(Category::where('service_id', $value)
                                        ->get()
                                        ->pluck('name', 'id')
                                        ->toArray()
                                    );

                                return $fields;
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
                    Box::make([
                        Switcher::make( 'Отобразить в первую очередь', 'Is_first')
                            ->updateOnPreview(),
                    ]),
                    Divider::make(),
                    Box::make([
                        Switcher::make( 'Скрыть', 'hidden')
                            ->updateOnPreview()
                    ])
                ])
                    ->columnSpan(4)
            ]),
            Divider::make(),
            Box::make([
                Column::make([
                    Image::make('Основное фото', 'image')
                        ->dir('mdt/images')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable()
                        ->required($this->getResource()->getItem() === null)
                ])->columnSpan(6),
                Column::make([
                    Tabs::make([
                        Tab::make('Видео', [
                            File::make('', 'video')
                                ->dir('mdt/video/videos')
                                ->allowedExtensions(['mp4'])
                                ->removable()
                                ->disableDownload()
                        ]),
                        Tab::make('Ссылка на видео', [
                            Url::make('','link')->blank()
                        ])
                    ]),
                    Image::make('Preview')
                        ->dir('mdt/video/preview')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable()
                ])->columnSpan(6)
            ])

        ];

        if (!$this->getResource()->getItem()) {
            return $fields;
        }

        return array_merge($fields, [
            Divider::make(),
            Collapse::make('Добавить фото', [
                Box::make([
                    RelationRepeater::make(
                        '',
                        'images',
                        resource: ServiceContentImageResource::class)
                        ->vertical()
                        ->fields([
                            Grid::make([
                                Column::make([
                                    Box::make([
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
                            ])
                        ])->removable()
                ])
            ])
        ]);
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

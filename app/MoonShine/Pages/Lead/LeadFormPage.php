<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Lead;

use App\MoonShine\Resources\Lead\LeadContentResource;
use App\MoonShine\Resources\Lead\LeadImageResource;
use App\MoonShine\Resources\Lead\LeadVideoResource;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\MoonShineRequest;
use MoonShine\Pages\Crud\FormPage;
use Throwable;

class LeadFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws Throwable
     */
    public function fields(): array
    {
        $createForm = [
            Grid::make([
                Column::make([
                    Text::make('Название', 'title')
                        ->required(),
                ])->columnSpan(8),
                Column::make([
                    Date::make('Дата публикации', 'date')
                        ->required(),
                    Switcher::make('Новость активна', 'is_active'),
                ])->columnSpan(4)
            ]),
            Block::make([
                TinyMce::make('Текст новости', 'content'),
            ]),
            Divider::make(),
            Grid::make([
                Column::make([
                    Block::make([
                        Image::make('Фотография', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('lead/images')
                            ->removable()
                    ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        File::make('Видео', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('lead/videos')->removable()


                    ])
                ])->columnSpan(6)
            ]),

        ];

        if ($this->getResource()->getItem()) {
             $createForm = array_merge($createForm, [
                 Divider::make(),
                 Collapse::make('Добавить блок с текстом', [
                     Block::make([
                         Json::make('Текст', 'contents')
                             ->asRelation(new LeadContentResource())
                             ->fields([
                                 TinyMce::make('', 'content')
                             ])
                             ->removable()
                     ])
                 ]),
                 Divider::make(),
                 Collapse::make('Добавить фото', [
                     Block::make([
                         Json::make('Фото', 'images')
                             ->asRelation(new LeadImageResource())
                             ->fields([
                                 Image::make('', 'image')
                                     ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                     ->dir('lead/images')
                                     ->removable(),
                                 Text::make('', 'description')
                                     ->placeholder('Добавьте описание')
                             ])
                             ->removable()
                     ])
                 ]),
                 Divider::make(),
                 Collapse::make('Добавить видео', [
                     Block::make([
                         Json::make('Видео', 'videos')
                             ->asRelation(new LeadVideoResource())
                             ->fields([
                                 File::make('', 'video')
                                     ->allowedExtensions(['mp4'])
                                     ->disableDownload()
                                     ->dir('lead/videos')
                                     ->removable(),
                                 Text::make('', 'description')
                                     ->placeholder('Добавьте описание')
                             ])
                             ->removable()
                     ])
                 ])]
             );
    }
        return $createForm;
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

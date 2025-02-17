<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Lead;

use App\MoonShine\Resources\LeadContentResource;
use App\MoonShine\Resources\LeadImageResource;
use App\MoonShine\Resources\LeadVideoResource;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\ActionGroup;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\MoonShineRequest;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use Throwable;

class LeadFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws Throwable
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title'),
                        TinyMce::make('Текст новости', 'content'),
                        Image::make('Фотографии', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('lead/images')
                            ->removable(),
                        File::make('Видео', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('lead/videos')
                            ->removable()
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        Date::make('Дата публикации', 'date'),
                        Switcher::make('Новость активна', 'is_active'),

                    ]),
                Block::make([
                        ActionGroup::make([
                            ActionButton::make(
                                label: 'Добавить текст',
                                url: '#',
                                item: ['id' => 'add']

                            )->method('getTextBlock')
                                ->primary()
                                ->icon('heroicons.outline.plus'),
                            ActionButton::make(
                                label: 'Добавить фото',
                                url: 'https://moonshine-laravel.com',
                            )
                                ->primary()
                                ->icon('heroicons.outline.plus'),
                            ActionButton::make(
                                label: 'Добавить видео',
                                url: 'https://moonshine-laravel.com',
                            )
                                ->primary()
                                ->icon('heroicons.outline.plus')
                        ])
                    ])
                ])->columnSpan(4),
            ]),
            Divider::make(),
            Block::make([
                Json::make('Текст', 'contents')
                    ->asRelation(new LeadContentResource())
                    ->fields([
                        TinyMce::make('', 'content')
                    ])
                    ->creatable(
                        button: ActionButton::make('New', '#', ['id' => 'add'])->primary()->method(
                            'updateSomething',
                            params: ['resourceItem' => $this->getResource()->getItemID()]
                        )
                    )
                    ->removable()
            ]),
            Divider::make(),
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
            ]),
            Divider::make(),
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
        ];
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

    /**
     * @throws Throwable
     */
    public function getTextBlock(MoonShineRequest $request)
    {
        Json::make('Текст', 'contents')
            ->asRelation(new LeadContentResource())
            ->fields([
                TinyMce::make('', 'content')
            ])
            ->creatable(
                button: ActionButton::make('New', '#', ['id' => 'add'])->primary()->method(
                    'updateSomething',
                    params: ['resourceItem' => $this->getResource()->getItemID()]
                )
            )
            ->removable();
    }
}

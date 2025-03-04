<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\News\NewsContentResource;
use App\MoonShine\Resources\News\NewsImageResource;
use App\MoonShine\Resources\News\NewsVideoResource;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\DetailPage;
use Throwable;

class NewsDetailPage extends DetailPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws Throwable
     */
    public function fields(): array
    {
        return [
            Text::make('Название', 'title'),
            TinyMce::make('Текст новости', 'content'),
            Image::make('Фотографии', 'image')
                ->dir('lead/images'),
            File::make('Видео', 'video')
                ->dir('lead/videos'),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'is_active')->updateOnPreview(),
            Json::make('Текст', 'contents')
                ->asRelation(new NewsContentResource())
                ->fields([
                    TinyMce::make('', 'content')
                ]),
            Json::make('Фото', 'images')
                ->asRelation(new NewsImageResource())
                ->fields([
                    Image::make('', 'image')
                        ->dir('lead/images'),
                    Text::make('', 'description')
                        ->placeholder('Добавьте описание')
                ]),
            Json::make('Видео', 'videos')
                ->asRelation(new NewsVideoResource())
                ->fields([
                    File::make('', 'video')
                        ->dir('lead/videos'),
                    Text::make('', 'description')
                        ->placeholder('Добавьте описание')
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
}

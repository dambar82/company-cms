<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\News\NewsContentResource;
use App\MoonShine\Resources\ProjectResource;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;
use Throwable;


class NewsDetailPage extends DetailPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title'),
            TinyMce::make('Текст новости', 'content'),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'is_active')->updateOnPreview(),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true),
            HasMany::make('Текст', 'contents', resource: NewsContentResource::class)
                ->fields([
                    TinyMce::make('Текст', 'content'),
                    Image::make('Фото', 'image'),
                    File::make('Видео', 'video'),
                    Url::make('Ссылка на видео','link')
                ]),
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\News;

use App\Models\NewsContent;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Url;

/**
 * @extends ModelResource<NewsContent>
 */
class NewsContentResource extends ModelResource
{
    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected bool $stickyTable = true;

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected string $model = NewsContent::class;

    protected string $title = 'NewsContents';

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                TinyMce::make('Текст', 'text'),
                Image::make('Фото', 'image')
                    ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ->dir('news/images')
                    ->removable(),
                File::make('Видео', 'video')
                    ->allowedExtensions(['mp4'])
                    ->disableDownload()
                    ->dir('news/videos')
                    ->removable(),
                Url::make('Ссылка на видео','link')
            ])
        ];
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            TinyMce::make('Текст', 'text'),
            Image::make('Фото', 'image')
                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                ->dir('news/images')
                ->removable(),
            File::make('Видео', 'video')
                ->allowedExtensions(['mp4'])
                ->disableDownload()
                ->dir('news/videos')
                ->removable(),
            Url::make('Ссылка на видео','link')
        ];
    }

    /**
     * @param NewsContent $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

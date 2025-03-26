<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\News\NewsContentResource;
use App\MoonShine\Resources\ProjectResource;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Support\DTOs\AsyncCallback;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\ActionGroup;
use MoonShine\UI\Components\Icon;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Url;
use Throwable;


class NewsFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     * @throws Throwable
     */
    protected function fields(): iterable
    {
        $formFields = [
            Grid::make([
                Column::make([
                    Box::make([
                        Text::make('Название', 'title')->reactive(),
                        TextArea::make('Meta-описание', 'content'),
                        Slug::make('Slug')->from('title')
                            ->live()
                            ->locked()
                            ->separator('_'),
                    ])
                ])->columnSpan(8),
                Column::make([
                    Box::make([
                        Date::make('Дата публикации', 'date')->required(),
                        Switcher::make('Новость активна', 'active')->updateOnPreview(),
                        BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                            ->required(),
                    ])
                ])->columnSpan(4)
            ]),
        ];

        if($this->getResource()->getItem()) {
            $formFields = array_merge($formFields, [
                Divider::make(),
                HasMany::make(
                    'Контент',
                    'contents',
                     resource: NewsContentResource::class
                )
                    ->fields([
                        Preview::make(formatted: static fn() => Icon::make('bars-4')),
                        Text::make('Позиция', 'position'),
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
                    ])->modifyTable(fn(TableBuilder $table, bool $preview) => $preview ? $table : $table
                        ->reorderable(url: '/news_content_reorder/' . $this->getResource()->getItemID(), key: 'id', group: 'group-name')),

                Div::make()->customAttributes([
                    'id' => 'add-inputs'
                ]),
                Divider::make(),
                ActionGroup::make([
                    ActionButton::make('Добавить текст')
                        ->method(
                            'addText',
                            ['key' => 'text[]'],
                            callback: AsyncCallback::with(afterResponse: 'myResponse'),
                            resource: $this->getResource()
                        )->secondary(),
                    ActionButton::make('Добавить фото')
                        ->method(
                            'addImage',
                            ['key' => 'name[]'],
                            callback: AsyncCallback::with(afterResponse: 'myResponse'),
                            resource: $this->getResource()
                        )->secondary(),
                    ActionButton::make('Добавить видео')
                        ->method(
                            'addVideo',
                            ['key' => 'name[]'],
                            callback: AsyncCallback::with(afterResponse: 'myResponse'),
                            resource: $this->getResource()
                        )->secondary(),
                ])
            ]);
        }

        return $formFields;
    }
}

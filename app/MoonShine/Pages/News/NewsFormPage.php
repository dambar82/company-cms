<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\News\NewsContentResource;
use App\MoonShine\Resources\ProjectResource;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Url;
use Throwable;


class NewsFormPage extends FormPage
{
    public array $fields = [];

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
                ActionButton::make('Добавить текст')
                    ->method('addTextBlock'),

                Divider::make(),
                Collapse::make('Добавить контент', [
                    Box::make([
                        RelationRepeater::make(
                            '',
                            'contents',
                            resource: NewsContentResource::class)
                            ->fields([
                                Collapse::make('Текст', [
                                    TinyMce::make('', 'content')
                                ]),
                                Collapse::make('Фото', [
                                    Image::make('Фото', 'image')
                                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                        ->dir('news/images')
                                        ->removable(),
                                ]),
                                Collapse::make('Видео', [
                                    Tabs::make([
                                        Tab::make('Видео', [
                                            File::make('Видео', 'video')
                                                ->allowedExtensions(['mp4'])
                                                ->disableDownload()
                                                ->dir('news/videos')
                                                ->removable(),
                                        ]),
                                        Tab::make('Ссылка на видео', [
                                            Url::make('Ссылка на видео','link')->blank()
                                        ])
                                    ])
                                ])
                            ])
                            ->removable()
                            ->vertical()->creatable(limit: 5, button: ActionButton::make('New', '#')->showInDropdown())
                    ])
                ])
            ]);
        }
        $this->saveFields($formFields);

        return $this->fields;
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

    /**
     * @throws Throwable
     */
    public function saveFields($fields): void
    {
        $this->fields = $fields;
    }

    public function addTextBlock()
    {
        return [
            Collapse::make('Добавить текст', [
                Box::make([
                    RelationRepeater::make(
                        '',
                        'contents',
                        resource: NewsContentResource::class
                    )
                        ->fields([
                            Collapse::make('Текст', [
                                TinyMce::make('', 'content')
                            ])
                        ])
                        ->removable()
                        ->creatable(false)
                ])
            ])
        ];
    }
}

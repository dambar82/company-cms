<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\Models\News;
use App\MoonShine\Components\TextComponent;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\NewsContentResource;
use App\MoonShine\Resources\NewsImageResource;
use App\MoonShine\Resources\NewsVideoResource;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Template;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Url;
use MoonShine\Pages\Crud\FormPage;
use Throwable;

class NewsFormPage extends FormPage
{
    public array $fields = [];

    /**
     * @return list<MoonShineComponent|Field>
     * @throws Throwable
     */
    public function fields(): array
    {
        $formFields = [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title')->reactive(),
                        TextArea::make('Meta-описание', 'content')
                            ->hideOnIndex(),
                        Slug::make('Slug')->from('title')
                            ->live()
                            ->locked()
                            ->separator('_')
                            ->hideOnIndex(),
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        Date::make('Дата публикации', 'date')->required(),
                        Switcher::make('Новость активна', 'active')->updateOnPreview(),
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->required(),
                    ])
                ])->columnSpan(4)
            ]),
        ];

        if($this->getResource()->getItem()) {
            $formFields = array_merge($formFields, [

                ActionButton::make('Добавить текст')
                    ->method('addTextBlock'
                    ),

                Divider::make(),
                Collapse::make('Добавить контент', [
                    Block::make([
                        Json::make('', 'contents')
                            ->asRelation(new NewsContentResource())
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
                                    File::make('Видео', 'video')
                                        ->allowedExtensions(['mp4'])
                                        ->disableDownload()
                                        ->dir('news/videos')
                                        ->removable(),
                                ]),
                                Collapse::make('Ссылка на видео', [
                                    Url::make('Ссылка на видео', 'link')->expansion('http')
                                ]),
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
                Block::make([
                    Json::make('', 'contents')
                        ->asRelation(new NewsContentResource())
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

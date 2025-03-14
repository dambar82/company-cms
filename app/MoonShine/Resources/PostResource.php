<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Post>
 */
class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Посты';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'), Text::make('Заголовок', 'title'),
            Image::make('Изображения', 'images')
                ->multiple()
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Grid::make([
                    Column::make([
                        Box::make([
                            Text::make('Заголовок', 'title'),
                            TinyMce::make('Текст', 'text'),
                        ])
                    ])
                ]),
                Divider::make(),
                Grid::make([
                    Column::make([
                        Box::make([
                            Image::make('Изображения', 'images')
                                ->dir('posts/images')
                                ->multiple()
                                ->removable()
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ]),
                        Divider::make(),
                        Box::make([
                            File::make('PDF-документы', 'documents')
                                ->dir('posts/documents')
                                ->multiple()
                                ->allowedExtensions(['pdf'])
                        ])
                    ])->columnSpan(6),
                    Column::make([
                        Box::make([
                            File::make('Аудио', 'audios')
                                ->dir('posts/audios')
                                ->multiple()
                                ->allowedExtensions(['mp3'])
                        ]),
                        Divider::make(),
                        Box::make([
                            File::make('Видео', 'videos')
                                ->dir('posts/videos')
                                ->multiple()
                                ->allowedExtensions(['mp4'])
                        ])
                    ])->columnSpan(6)
                ])
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title'), Text::make('Заголовок', 'title'),
            Image::make('Изображения', 'images')
                ->multiple(),
            File::make('PDF-документы', 'documents')
                ->multiple(),
            File::make('Аудио', 'audios')
                ->multiple(),
            File::make('Видео', 'videos')
                ->multiple()
        ];
    }

    /**
     * @param Post $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

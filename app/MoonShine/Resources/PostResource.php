<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Post>
 */
class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        ID::make()->sortable()->hideOnIndex(),
                        Text::make('Заголовок', 'title'),
                        TinyMce::make('Текст', 'text')->hideOnIndex(),

                    ])
                ])
            ]),
            Divider::make(),
            Grid::make([
                    Column::make([
                        Block::make([
                            Image::make('Изображения', 'images')
                                ->dir('posts/images')
                                ->multiple()
                                ->removable()
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ]),
                        Divider::make(),
                        Block::make([
                            File::make('PDF-документы', 'documents')
                                ->dir('posts/documents')
                                ->multiple()
                                ->allowedExtensions(['pdf'])
                                ->hideOnIndex()
                        ])
                    ])->columnSpan(6),

                    Column::make([
                        Block::make([
                            File::make('Аудио', 'audios')
                                ->dir('posts/audios')
                                ->multiple()
                                ->allowedExtensions(['mp3'])
                                ->hideOnIndex()
                        ]),
                        Divider::make(),
                        Block::make([
                            File::make('Видео', 'videos')
                                ->dir('posts/videos')
                                ->multiple()
                                ->allowedExtensions(['mp4'])
                                ->hideOnIndex()
                        ])
                    ])->columnSpan(6)
])



        ];
    }

    /**
     * @param Post $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }
}

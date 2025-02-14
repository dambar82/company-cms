<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\News;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Url;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<News>
 */
class AminaNewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости Амина';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title'),
                        TinyMce::make('Текст новости', 'content')
                            ->hideOnIndex(),
                        Image::make('Фотографии', 'images')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('news/images')
                            ->multiple()
                            ->removable(),
                        File::make('Видео', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('news/video')
                            ->hideOnIndex()
                            ->removable()
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([

                        Url::make('Добавить ссылку на видео','link_to_video')
                            ->expansion('http')
                            ->hideOnIndex(),
                        Date::make('Дата публикации', 'date'),
                        Switcher::make('Новость активна', 'active')->updateOnPreview(),
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->required(),
                    ])
                ])->columnSpan(4)
            ])
        ];
    }

    /**
     * @param News $item
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

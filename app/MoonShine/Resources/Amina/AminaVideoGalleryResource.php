<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\VideoGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<VideoGallery>
 */
class AminaVideoGalleryResource extends ModelResource
{
    protected string $model = VideoGallery::class;

    protected string $title = 'Видеогалереи Амина';

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
                        Text::make('Название', 'name'),
                        Text::make('Описание', 'title'),
                        Image::make( 'preview')
                            ->dir('amina/preview')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable(),
                        File::make('Видео', 'video')
                            ->dir('amina/video')
                            ->hideOnIndex()
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->removable()
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 1))
                            ->required(),
                    ])
                ])->columnSpan(4)
            ])
        ];
    }

    /**
     * @param VideoGallery $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }

    public function query(): Builder
    {
        return parent::query()
            ->join('video_gallery_project as vgp', 'video_galleries.id', '=', 'vgp.video_gallery_id')
            ->join('projects as p', 'p.id', '=', 'vgp.project_id')
            ->where('p.id', 1)
            ->select('video_galleries.*');
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\VideoGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<VideoGallery>
 */
class MDTVideoGalleryResource extends ModelResource
{
    protected string $model = VideoGallery::class;

    protected string $title = 'Видеогалереи МЦТ';

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
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        BelongsToMany::make('', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 3))
                            ->required()
                    ])
                ])->columnSpan(4)

            ]),
            TinyMce::make('Описание', 'title')
                ->hideOnIndex(),

                Flex::make([
                    Image::make( 'preview')
                        ->dir('mdt/preview')
                        ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ->removable(),
                    File::make('Видео', 'video')
                        ->dir('mdt/video')
                        ->hideOnIndex()
                        ->allowedExtensions(['mp4'])
                        ->disableDownload()
                        ->removable()
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
            ->where('p.id', 3)
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

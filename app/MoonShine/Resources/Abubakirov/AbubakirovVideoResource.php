<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use App\Models\Video;
use App\Models\VideoGallery;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Video>
 */
class AbubakirovVideoResource extends ModelResource
{
    protected string $model = Video::class;

    protected string $title = 'Видео Абубакиров';

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
                        File::make('Видео', 'video')
                            ->dir('abubakirov/video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->hideOnIndex(),
                        Text::make('Описание', 'description'),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Select::make('Видеогалерея', 'video_gallery_id')
                            ->options(VideoGallery::join('video_gallery_project', 'video_gallery_project.video_gallery_id', '=', 'video_galleries.id')
                                ->where('video_gallery_project.project_id', 2)
                                ->pluck('video_galleries.name', 'video_galleries.id')
                                ->toArray())
                            ->required()
                    ])
                ])->columnSpan(4)
            ])
        ];
    }

    /**
     * @param Video $item
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
            ->join('video_galleries as vg', 'videos.video_gallery_id', '=', 'vg.id')
            ->join('video_gallery_project as vgp', 'vg.id', '=', 'vgp.video_gallery_id')
            ->join('projects as p', 'vgp.project_id', '=', 'p.id')
            ->where('p.id', 2)
            ->select('videos.*');
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

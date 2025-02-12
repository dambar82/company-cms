<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

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
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Video>
 */
class AminaVideoResource extends ModelResource
{
    protected string $model = Video::class;

    protected string $title = 'Видео Амина';

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
                            ->dir('amina/video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->hideOnIndex(),
                        Text::make('Описание', 'description'),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Select::make('Видеогалерея', 'video_gallery_id')
                            ->options(VideoGallery::pluck('name', 'id')->toArray())
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
            ->where('p.id', 1)
            ->select('videos.*');
    }
}

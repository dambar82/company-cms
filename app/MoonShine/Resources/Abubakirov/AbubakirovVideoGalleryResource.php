<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\VideoGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<VideoGallery>
 */
class AbubakirovVideoGalleryResource extends ModelResource
{
    protected string $model = VideoGallery::class;

    protected string $title = 'Видеогалереи Абубакиров';

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
                            ->dir('abubakirov/preview')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
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
            ->where('p.id', 2)
            ->select('video_galleries.*');
    }
}

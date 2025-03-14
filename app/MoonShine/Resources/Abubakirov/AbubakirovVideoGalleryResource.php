<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use App\Models\VideoGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<VideoGallery>
 */
class AbubakirovVideoGalleryResource extends ModelResource
{
    protected string $model = VideoGallery::class;

    protected string $title = 'Видеогалереи Абубакиров';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return FieldContract
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            ID::make(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'title'),
            Image::make( 'preview'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @return FieldContract
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Grid::make([
                    Column::make([
                        Box::make([
                            Text::make('Название', 'name'),
                            Text::make('Описание', 'title'),
                            Image::make( 'preview')
                                ->dir('abubakirov/preview')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ])
                    ])->columnSpan(8),

                    Column::make([
                        Box::make([
                            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                                ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 2))
                                ->required(),
                        ])
                    ])->columnSpan(4)
                ]),
                Divider::make(),
                Box::make([
                    RelationRepeater::make(
                        'Видео',
                        'videos',
                        resource: AbubakirovVideoResource::class
                    )
                        ->fields([
                            File::make('', 'video')
                                ->dir('abubakirov/video')
                                ->allowedExtensions(['mp4'])
                                ->disableDownload(),
                            Text::make('', 'description')->placeholder('Добавьте описание')
                        ])
                        ->creatable()
                        ->removable()
                ])
            ])
        ];
    }

    /**
     * @return FieldContract
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'title'),
            Image::make( 'preview'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
        ];
    }

    /**
     * @param VideoGallery $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    public function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->join('video_gallery_project as vgp', 'video_galleries.id', '=', 'vgp.video_gallery_id')
            ->join('projects as p', 'p.id', '=', 'vgp.project_id')
            ->where('p.id', 2)
            ->select('video_galleries.*');
    }
}

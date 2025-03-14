<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\VideoGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;

/**
 * @extends ModelResource<VideoGallery>
 */
class AminaVideoResource extends ModelResource
{
    protected string $model = VideoGallery::class;

    protected string $title = 'Видео Амина';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Image::make( 'preview'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Grid::make([
                    Column::make([
                        Box::make([
                            ID::make(),
                            Text::make('Название', 'name')
                                ->required(),
                            Text::make('Описание', 'title'),
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Hidden::make('project')->setValue(1),
                            Image::make( 'preview')
                                ->dir('amina/preview')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable(),
                            Tabs::make([
                                Tab::make('Видео', [
                                    File::make('Видео', 'video')
                                        ->dir('amina/video')
                                        ->allowedExtensions(['mp4'])
                                        ->disableDownload()
                                        ->removable(),
                                ]),
                                Tab::make('Ссылка на видео', [
                                    Url::make('','link')->blank()
                                ])
                            ])
                        ])
                    ])->columnSpan(4)
                ])
            ])
        ];
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'title'),
            Image::make( 'preview'),
            File::make('Видео', 'video'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
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
            ->where('p.id', 1)
            ->select('video_galleries.*');
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use App\Models\ImageGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<ImageGallery>
 */
class AbubakirovImageGalleryResource extends ModelResource
{
    protected string $model = ImageGallery::class;

    protected string $title = 'Фотогалереи Абубакиров';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'title'),
            Image::make('Изображение', 'caption'),
            BelongsToMany::make('Проект', 'projects', resource: app(ProjectResource::class))
                ->inLine('', true)
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        $fields = [
            Box::make([
                Grid::make([
                    Column::make([
                        Box::make([
                            Text::make('Название', 'name'),
                            Text::make('Описание', 'title')
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Image::make('Изображение', 'caption')
                                ->dir('abubakirov/gallery')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                        ])
                    ])->columnSpan(4),
                    Hidden::make('project')->setValue(2)
                ])
            ])
        ];

        if ($this->isUpdateFormPage()) {
            $fields = array_merge($fields, [
                Divider::make(),
                Box::make([
                    RelationRepeater::make(
                        'Фотографии',
                        'images',
                        resource: AbubakirovImageResource::class
                    )
                        ->fields([
                            ID::make(),
                            Image::make('', 'image')
                                ->dir('abubakirov/img')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable(),
                            Text::make('', 'description')->placeholder('Добавьте описание')
                        ])
                        ->creatable()
                        ->removable()
                ])
            ]);
        }

        return $fields;
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Описание', 'title'),
            Image::make('Изображение', 'caption'),
            BelongsToMany::make('Проект', 'projects', resource: app(ProjectResource::class))
        ];
    }

    /**
     * @param ImageGallery $item
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
            ->join('image_gallery_project as igp', 'image_galleries.id', '=', 'igp.image_gallery_id')
            ->join('projects as p', 'p.id', '=', 'igp.project_id')
            ->where('p.id', 2)
            ->select('image_galleries.*');
    }
}

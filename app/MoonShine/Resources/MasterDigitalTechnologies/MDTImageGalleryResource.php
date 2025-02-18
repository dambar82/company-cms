<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\ImageGallery;
use App\MoonShine\Resources\Abubakirov\AbubakirovImageResource;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Image as Img;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<ImageGallery>
 */
class MDTImageGalleryResource extends ModelResource
{
    protected string $model = ImageGallery::class;

    protected string $title = 'Услуги МЦТ';

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
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 3))
                            ->required()
                    ])
                ])->columnSpan(4),
            ]),
            Divider::make(),
            Block::make([
                Json::make('Фотографии', 'images')
                    ->hideOnIndex()
                    ->asRelation(new MDTImageResource())
                    ->fields([
                        Img::make('', 'image')
                            ->dir('mdt/images')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable(),
                        Text::make('', 'description')->placeholder('Добавьте описание')
                    ])
                    ->creatable()
                    ->removable()
            ])
        ];
    }

    /**
     * @param ImageGallery $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'projects' => ['required']
        ];
    }

    public function import(): ?ImportHandler
    {
        return null;
    }

    public function export(): ?ExportHandler
    {
        return null;
    }

    public function query(): Builder
    {
        return parent::query()
            ->join('image_gallery_project as igp', 'image_galleries.id', '=', 'igp.image_gallery_id')
            ->join('projects as p', 'p.id', '=', 'igp.project_id')
            ->where('p.id', 3)
            ->select('image_galleries.*');
    }
}

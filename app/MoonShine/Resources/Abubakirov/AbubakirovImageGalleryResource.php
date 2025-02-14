<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use App\Models\ImageGallery;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image;
use MoonShine\Fields\Image as Img;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Throwable;

/**
 * @extends ModelResource<ImageGallery>
 */
class AbubakirovImageGalleryResource extends ModelResource
{
    protected string $model = ImageGallery::class;

    protected string $title = 'Фотогалереи Абубакиров';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return array
     * @throws Throwable
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'name'),
                        Text::make('Описание', 'title'),
                        Image::make('Изображение', 'caption')
                            ->dir('abubakirov/gallery')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 2))
                            ->required()
                    ])
                ])->columnSpan(4),
            ]),
        Block::make([
            Json::make('Фотографии', 'images')
                ->hideOnIndex()
                ->asRelation(new AbubakirovImageResource())
                ->fields([
                    Img::make('', 'image')
                        ->dir('abubakirov/img')
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

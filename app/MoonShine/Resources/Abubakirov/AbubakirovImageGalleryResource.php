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
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

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
                        Image::make('Изображение', 'caption')
                            ->dir('abubakirov/gallery')
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
     * @param ImageGallery $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}

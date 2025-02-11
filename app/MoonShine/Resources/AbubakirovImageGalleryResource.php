<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\ImageGallery;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<ImageGallery>
 */
class AbubakirovImageGalleryResource extends ModelResource
{
    protected string $model = ImageGallery::class;

    protected string $title = 'Фотогалереи Абубакиров';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        ID::make()->sortable(),
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())->hideOnIndex(),
                        Text::make('Название', 'name'),
                        Text::make('Описание', 'title'),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Image::make('Изображение', 'caption')
                            ->dir('abubakirov/gallery')
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Abubakirov;

use App\Models\Image;
use App\Models\ImageGallery;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image as Img;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Image>
 */
class AbubakirovImageResource extends ModelResource
{
    protected string $model = Image::class;

    protected string $title = 'Фотографии Абубакиров';

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
                        Img::make('Изображение', 'image')
                            ->dir('abubakirov/img')
                            ->allowedExtensions(['png', 'jpg', 'jpeg']),
                        Text::make('Описание', 'description'),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Select::make('Фотогалерея', 'image_gallery_id')
                            ->options(ImageGallery::pluck('name', 'id')->toArray())
                            ->required()
                    ])
                ])->columnSpan(4)
            ])
        ];
    }

    /**
     * @param Image $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}

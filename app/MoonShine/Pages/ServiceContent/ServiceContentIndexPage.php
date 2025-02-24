<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\MoonShine\Resources\MasterDigitalTechnologies\CategoryResource;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;

class ServiceContentIndexPage extends IndexPage
{
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Text::make('Название', 'name')->required(),
            BelongsTo::make('Услуга', 'Service'),
            BelongsTo::make('Категория', 'category', resource: new CategoryResource()),
            Image::make('Фото', 'image'),
            Image::make('Видео', 'preview'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Poster;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;

/**
 * @extends ModelResource<Poster>
 */
class PosterResource extends ModelResource
{
    protected string $model = Poster::class;

    protected string $title = 'Плакаты - Татарстан - великой победе!';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Плакат', 'poster')
                ->dir('posters')
                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                ->removable()
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Image::make('Плакат', 'poster')
                    ->dir('posters')
                    ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ->removable()
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Image::make('Плакат', 'poster')
                ->dir('posters')
                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                ->removable()
        ];
    }

    /**
     * @param Poster $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use Illuminate\Database\Eloquent\Model;
use App\Models\AminaSong;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\Url;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<AminaSong>
 */
class AminaSongResource extends ModelResource
{
    protected string $model = AminaSong::class;

    protected string $title = 'Песни';

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
            Text::make('Название', 'title'),
            Image::make('Картинка', 'image')
                ->dir('amina/preview'),
            Switcher::make('Опубликовать', 'active')
                ->updateOnPreview()
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
                Grid::make([
                    Column::make([
                        Box::make([
                            ID::make(),
                            Text::make('Название', 'title')
                                ->required(),
                            TinyMce::make('Текст песни', 'content')
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                           Image::make('Картинка', 'image')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->dir('amina/preview')
                                ->removable(),
                            Divider::make(),
                            Switcher::make('Опубликовать', 'active')
                                ->updateOnPreview(),
                        ])
                    ])->columnSpan(4)
                ])
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
            Text::make('Название', 'title'),
            TinyMce::make('Текст песни', 'content'),
            Image::make('Картинка', 'image')
                ->dir('amina/preview'),
            Switcher::make('Опубликовать', 'active')
                ->updateOnPreview()
        ];
    }

    /**
     * @param AminaSong $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

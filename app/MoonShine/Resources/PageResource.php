<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Url;

/**
 * @extends ModelResource<Page>
 */
class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $title = 'Страницы';

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
            Text::make('Название', 'title'),
            Switcher::make('Видимость', 'is_visible')->updateOnPreview(),
            Image::make('Картинка', 'caption'),
            Date::make('Date')
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
                            Text::make('Название', 'title'),
                            Textarea::make('Короткое описание', 'short_description'),
                            TinyMce::make('Полное описание', 'full_content'),
                            Text::make('meta_title'),
                            Textarea::make('meta_description'),
                            Url::make('Ссылка', 'url')
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Checkbox::make('Видимость', 'is_visible'),
                            Checkbox::make('Разрешить комментарии', 'can_comment'),
                            Checkbox::make('Разрешить лайки', 'can_like')
                        ]),
                        Divider::make(),
                        Box::make([
                            Image::make('Картинка', 'caption')
                                ->dir('pages/captions')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable(),
                            Image::make('Фотографии', 'images')
                                ->dir('pages/images')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable()
                                ->multiple()
                        ]),
                        Divider::make(),
                        Box::make([
                            Date::make('Date')
                        ])
                    ])->columnSpan(4),
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
            Textarea::make('Короткое описание', 'short_description'),
            TinyMce::make('Полное описание', 'full_content'),
            Text::make('meta_title'),
            Textarea::make('meta_description'),
            Url::make('Ссылка', 'url'),
            Switcher::make('Видимость', 'is_visible')->updateOnPreview(),
            Switcher::make('Разрешить комментарии', 'can_comment')->updateOnPreview(),
            Switcher::make('Разрешить лайки', 'can_like')->updateOnPreview(),
            Image::make('Картинка', 'caption'),
            Image::make('Фотографии', 'images')->multiple(),
            Date::make('Date')
        ];
    }

    /**
     * @param Page $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

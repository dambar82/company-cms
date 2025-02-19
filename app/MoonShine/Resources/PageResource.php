<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Url;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Page>
 */
class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $title = 'Страницы';

    protected string $sortDirection = 'ASC';

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
                        ID::make()->sortable()->hideOnIndex(),
                        Text::make('Название', 'title'),
                        Textarea::make('Короткое описание', 'short_description')->hideOnIndex(),
                        TinyMce::make('Полное описание', 'full_content')->hideOnIndex(),
                        Text::make('meta_title')->hideOnIndex(),
                        Textarea::make('meta_description')->hideOnIndex(),
                        Url::make('url')->expansion('http')->hideOnIndex()
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        Checkbox::make('Видимость', 'is_visible')->hideOnIndex(),
                        Checkbox::make('Allow Comments', 'can_comment')->hideOnIndex(),
                        Checkbox::make('Allow Likes', 'can_like')->hideOnIndex()
                    ]),
                    Divider::make(),
                    Block::make([
                        Image::make('Картинка', 'caption')
                            ->dir('pages/captions')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable(),
                        Image::make('Фотографии', 'images')
                            ->dir('pages/images')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable()
                            ->multiple()
                            ->hideOnIndex()
                    ]),
                    Divider::make(),
                    Block::make([
                        Date::make('Date')
                    ])
                ])->columnSpan(4),
            ])
        ];
    }

    /**
     * @param Page $item
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

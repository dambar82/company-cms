<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Lead;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;

use MoonShine\ActionButtons\ActionButton;
use MoonShine\ActionButtons\ActionButtons;
use MoonShine\Components\ActionGroup;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Relationships\HasMany;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
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
 * @extends ModelResource<News>
 */
class LeadResourceOld extends ModelResource
{
    protected string $model = Lead::class;

    protected string $title = 'Вести';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     * @throws \Throwable
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title'),
                        TinyMce::make('Текст новости', 'content')->hideOnIndex(),
                        Image::make('Фотографии', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('lead/images')
                            ->removable(),
                        File::make('Видео', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('lead/videos')
                            ->hideOnIndex()
                            ->removable()
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Date::make('Дата публикации', 'date'),
                        Switcher::make('Новость активна', 'is_active')->updateOnPreview(),

                    ]),
                    Block::make([
                        ActionGroup::make([
                            ActionButton::make(
                                label: 'Добавить текст',
                                url: 'https://moonshine-laravel.com',
                            )
                                ->primary()
                                ->icon('heroicons.outline.plus'),
                            ActionButton::make(
                                label: 'Добавить фото',
                                url: 'https://moonshine-laravel.com',
                            )
                                ->primary()
                                ->icon('heroicons.outline.plus'),
                            ActionButton::make(
                                label: 'Добавить видео',
                                url: 'https://moonshine-laravel.com',
                            )
                                ->primary()
                                ->icon('heroicons.outline.plus')
                        ])
                    ])
                ])->columnSpan(4),
            ]),
            Divider::make(),
            Block::make([
                Json::make('Текст', 'contents')
                    ->asRelation(new LeadContentResource())
                    ->fields([
                        TinyMce::make('', 'content')
                    ])
                    ->creatable()
                    ->removable()
                    ->hideOnIndex()
                ]),
            Divider::make(),
            Block::make([
                Json::make('Фото', 'images')
                    ->asRelation(new LeadImageResource())
                    ->fields([
                        Image::make('', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('lead/images')
                            ->removable(),
                        Text::make('', 'description')
                            ->placeholder('Добавьте описание')
                    ])
                    ->creatable()
                    ->removable()
                    ->hideOnIndex()
                ]),
            Divider::make(),
            Block::make([
                Json::make('Видео', 'videos')
                    ->asRelation(new LeadVideoResource())
                    ->fields([
                        File::make('', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('lead/videos')
                            ->hideOnIndex()
                            ->removable(),
                        Text::make('', 'description')
                            ->placeholder('Добавьте описание')
                    ])
                    ->creatable()
                    ->removable()
                    ->hideOnIndex()
            ])
        ];
    }

    /**
     * @param News $item
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

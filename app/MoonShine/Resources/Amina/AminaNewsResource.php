<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\News;
use App\MoonShine\Resources\NewsContentResource;
use App\MoonShine\Resources\NewsImageResource;
use App\MoonShine\Resources\NewsVideoResource;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\TinyMce;
use MoonShine\Fields\Url;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<News>
 */
class AminaNewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости Амина';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     */
    public function fields(): array
    {
        $formFields = [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title')->reactive(),
                        TextArea::make('Meta-описание', 'content')
                            ->hideOnIndex(),
                        Slug::make('Slug')->from('title')
                            ->live()
                            ->locked()
                            ->separator('_')
                            ->hideOnIndex(),
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        Date::make('Дата публикации', 'date')->required(),
                        Switcher::make('Новость активна', 'active')->updateOnPreview(),
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->valuesQuery(fn(Builder $query, Field $field) => $query->where('id', 1))
                            ->required(),
                    ])
                ])->columnSpan(4)
            ]),
        ];

        if($this->getItemID()) {
            $formFields = array_merge($formFields, [
                Divider::make(),
                Collapse::make('Добавить блок с текстом', [
                    Block::make([
                        Json::make('Текст', 'contents')
                            ->asRelation(new NewsContentResource())
                            ->fields([
                                TinyMce::make('', 'content'),
                                Number::make('Sort')
                            ])
                            ->removable()
                    ])
                ]),
                Divider::make(),
                Collapse::make('Добавить фото', [
                    Block::make([
                        Json::make('Фото', 'image')
                            ->asRelation(new NewsImageResource())
                            ->fields([
                                Image::make('', 'image')
                                    ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                    ->dir('news/images')
                                    ->removable(),
                                Text::make('', 'description')
                                    ->placeholder('Добавьте описание')
                            ])
                            ->removable()
                    ])
                ]),
                Divider::make(),
                Collapse::make('Загрузить видео/Добавить ссылку', [
                    Block::make([
                        Tabs::make([
                           Tab::make('Загрузить видео', [
                               Json::make('', 'videos')
                                   ->asRelation(new NewsVideoResource())
                                   ->fields([
                                       File::make('', 'video')
                                           ->allowedExtensions(['mp4'])
                                           ->disableDownload()
                                           ->dir('news/videos')
                                           ->removable(),
                                       Text::make('', 'description')
                                           ->placeholder('Добавьте описание')
                                   ])
                                   ->removable()
                           ]),
                            Tab::make('Добавить ссылку на видео', [
                                Json::make('', 'videos')
                                    ->asRelation(new NewsVideoResource())
                                    ->fields([
                                        Url::make('', 'link')->expansion('http')
                                    ])
                                    ->removable()
                            ])
                        ]),

                    ])
                ])
            ]);
        }
        return $formFields;
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\News;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
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
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<News>
 */
class AminaNewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости Амина';

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
            Image::make('Фотографии', 'images')
                ->dir('news/images')
                ->multiple(),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'active')
                ->updateOnPreview(),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @return iterable
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Grid::make([
                    Column::make([
                        Box::make([
                            ID::make(),
                            Text::make('Название', 'title'),
                            TinyMce::make('Текст новости', 'content'),
                            Hidden::make('project')->setValue(1)
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Date::make('Дата публикации', 'date')->required(),
                            Divider::make(),
                            Switcher::make('Новость активна', 'active')->updateOnPreview(),
                            Divider::make(),
                            Image::make('Фотографии', 'images')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->dir('news/images')
                                ->multiple()
                                ->removable(),
                            Divider::make(),
                            Tabs::make([
                                Tab::make('Видео', [
                                    File::make('', 'video')
                                        ->allowedExtensions(['mp4'])
                                        ->disableDownload()
                                        ->dir('news/video')
                                        ->removable()
                                ]),
                                Tab::make('Ссылка на видео', [
                                    Url::make('','link_to_video')->blank()
                                ])
                            ])
                        ])
                    ])->columnSpan(4)
                ])
            ])
        ];
    }

    /**
     * @return iterable
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title'),
            TinyMce::make('Текст новости', 'content'),
            Image::make('Фотографии', 'images')
                ->dir('news/images')
                ->multiple(),
            File::make('Видео', 'video')
                ->dir('news/videos'),
            Url::make('Ссылка на видео','link_to_video'),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'active')->updateOnPreview(),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @param News $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    public function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->join('news_project as np', 'news.id', '=', 'np.news_id')
            ->join('projects as p', 'p.id', '=', 'np.project_id')
            ->where('p.id', 1)
            ->select('news.*');
    }
}

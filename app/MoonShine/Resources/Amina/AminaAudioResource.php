<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\Audio;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Hidden;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Audio>
 */
class AminaAudioResource extends ModelResource
{
    protected string $model = Audio::class;

    protected string $title = 'Аудио Амина';

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
            File::make('Аудио', 'path'),
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
                            Text::make('Название', 'title')
                                ->required()
                        ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Hidden::make('project')->setValue(1),
                            File::make('Аудио', 'path')
                                ->allowedExtensions(['mp3'])
                                ->disableDownload()
                                ->dir('amina/audio')
                                ->required($this->isCreateFormPage())
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
            ID::make()->sortable(),
            Text::make('Название', 'title'),
            File::make('Аудио', 'path')
                ->dir('amina/audio'),
            BelongsToMany::make('Проект', 'projects', resource: ProjectResource::class)
                ->inLine('', true)
        ];
    }

    /**
     * @param Audio $item
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
            ->join('audio_project as ap', 'audios.id', '=', 'ap.audio_id')
            ->join('projects as p', 'p.id', '=', 'ap.project_id')
            ->where('p.id', 1)
            ->select('audios.*');
    }
}

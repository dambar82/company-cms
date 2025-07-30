<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\AudioMinus;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<AudioMinus>
 */
class AminaAudioMinusesResource extends ModelResource
{
    protected string $model = AudioMinus::class;

    protected bool $stickyTable = true;

    protected string $title = 'Аудио-минусовки Амина';

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
            File::make('Аудио', 'path')
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
                            File::make('Аудио(минус)', 'path')
                                ->allowedExtensions(['mp3'])
                                ->disableDownload()
                                ->dir('amina/audio/minuses')
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
                ->dir('amina/audio/minuses')
        ];
    }

    /**
     * @param AudioMinus $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

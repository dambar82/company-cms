<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\Audio;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Audio>
 */
class AminaAudioResource extends ModelResource
{
    protected string $model = Audio::class;

    protected string $title = 'Аудио Амина';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        Text::make('Название', 'title'),
                        File::make('Аудио', 'path')
                            ->allowedExtensions(['mp3'])
                            ->disableDownload()
                            ->dir('amina/audio')
                            ->hideOnIndex(),

                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->hideOnIndex()
                            ->required()
                    ])
                ])->columnSpan(4)
            ])
        ];
    }

    /**
     * @param Audio $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}

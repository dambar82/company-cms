<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Quiz;
use App\MoonShine\Resources\ProjectResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Quiz>
 */
class QuizResource extends ModelResource
{
    protected string $model = Quiz::class;

    protected string $title = 'Викторины';

    public string $column = 'name';

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
                        Text::make('Название', 'name'),
                        Image::make('Картинка', 'image')
                            ->dir('quiz')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                    ])
                ])->columnSpan(8),
                Column::make([
                    Block::make([
                        BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                            ->required()->inLine()
                    ])
                ])->columnSpan(4)

            ])
        ];
    }

    /**
     * @param Quiz $item
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

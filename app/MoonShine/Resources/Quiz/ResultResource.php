<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Quiz;

use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Result>
 */
class ResultResource extends ModelResource
{
    protected string $model = Result::class;

    protected string $title = 'Результаты';

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
                        Select::make('Викторина', 'quiz_id')
                            ->options(
                                Quiz::pluck('name', 'id')->toArray()
                            )
                        ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Text::make('Рузультат', 'result')
                        ])
                ])->columnSpan(6),
            ])
        ];
    }

    /**
     * @param Result $item
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

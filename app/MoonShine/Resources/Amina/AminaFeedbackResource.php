<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\AminaFeedback;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends ModelResource<AminaFeedback>
 */
class AminaFeedbackResource extends ModelResource
{
    protected string $model = AminaFeedback::class;

    protected string $title = 'Отзывы';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return FieldContract
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Textarea::make('Отзыв', 'text'),
            Image::make('Картинка', 'image'),
            Textarea::make('Организация', 'organization'),
            Checkbox::make('Частное лицо', 'private_person')
        ];
    }

    /**
     * @return FieldContract
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Grid::make([
                    Column::make([
                        Box::make([
                            Textarea::make('Отзыв', 'text'),
                            Image::make('Картинка', 'image')
                    ])
                    ])->columnSpan(8),
                    Column::make([
                        Box::make([
                            Textarea::make('Организация', 'organization')
                                ->showWhen('private_person', 0),
                            Checkbox::make('Частное лицо', 'private_person')
                                ->disabled()
                                ->showWhen('organization', '')
                        ])
                    ])->columnSpan(4)
                ])
            ])
        ];
    }

    /**
     * @return FieldContract
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            ID::make()->sortable(),
            Textarea::make('Отзыв', 'text'),
            Image::make('Картинка', 'image'),
            Textarea::make('Организация', 'organization'),
            Checkbox::make('Частное лицо', 'private_person')
        ];
    }

    /**
     * @param AminaFeedback $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}

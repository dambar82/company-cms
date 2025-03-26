<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\Models\AminaFeedback;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
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
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Textarea::make('Отзыв', 'text'),
            Image::make('Картинка', 'image'),
            Text::make('Создатель', 'creator'),
            Text::make('Должность', 'job_title'),
            Text::make('Регион', 'region'),
            Text::make('ФИО', 'fio'),
            Text::make('Email')
        ];
    }

    /**
     * @return iterable
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
                           Text::make('Создатель', 'creator'),
                           Text::make('Должность', 'job_title'),
                           Text::make('Регион', 'region'),
                           Text::make('ФИО', 'fio'),
                           Text::make('Email')
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
            ID::make()->sortable(),
            Textarea::make('Отзыв', 'text'),
            Image::make('Картинка', 'image'),
            Text::make('Создатель', 'creator'),
            Text::make('Должность', 'job_title'),
            Text::make('Регион', 'region'),
            Text::make('ФИО', 'fio'),
            Text::make('Email')
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

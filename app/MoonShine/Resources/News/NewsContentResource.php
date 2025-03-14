<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\News;

use App\Models\NewsContent;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;

/**
 * @extends ModelResource<NewsContent>
 */
class NewsContentResource extends ModelResource
{
    protected string $model = NewsContent::class;

    protected string $title = 'NewsContents';

    /**
     * @return iterable
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
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
        ];
    }

    /**
     * @param NewsContent $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()
            ->except(Action::UPDATE)
            ->except(Action::CREATE)
            ->except(Action::DELETE)
            ->except(Action::VIEW)
            ->except(Action::MASS_DELETE);
    }
}

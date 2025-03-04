<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\ProjectResource;
use MoonShine\Exceptions\FieldException;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsToMany;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use Throwable;

class NewsIndexPage extends IndexPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws FieldException
     */
    public function fields(): array
    {
        return [
            Text::make('Название', 'title'),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'is_active')->updateOnPreview(),
            BelongsToMany::make('Проект', 'projects', resource: new ProjectResource())
                ->inLine()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

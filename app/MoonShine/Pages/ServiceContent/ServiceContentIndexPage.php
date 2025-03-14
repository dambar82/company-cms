<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\ServiceContent;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;


class ServiceContentIndexPage extends IndexPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->required(),
            Select::make('Услуга', 'service_id')
                ->nullable()
                ->options(Service::query()->get()->pluck('name', 'id')->toArray())
                ->reactive(function(FieldsContract  $fields, ?string $value): FieldsContract  {
                    $fields->findByColumn('category_id')
                        ?->options(Category::where('service_id', $value)
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray()
                        );

                    return $fields;
                })
                ->required(),
            Select::make('Категория', 'category_id')
                ->nullable()
                ->options(Category::query()->get()->pluck('name', 'id')->toArray())
                ->reactive()
                ->required(),
            Image::make('Фото', 'image'),
            Image::make('Видео', 'preview'),
            Switcher::make( 'Отобразить в первую очередь', 'Is_first')
                ->updateOnPreview(),
            Switcher::make( 'Скрыть', 'hidden')
                ->updateOnPreview(),
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}

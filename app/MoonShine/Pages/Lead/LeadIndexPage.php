<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Lead;

use MoonShine\Exceptions\FieldException;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Field;
use Throwable;

class LeadIndexPage extends IndexPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws FieldException
     */
    public function fields(): array
    {
        return [
            Text::make('Название', 'title'),
            Image::make('Фотографии', 'image')
                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                ->dir('lead/images')
                ->removable(),
            Date::make('Дата публикации', 'date'),
            Switcher::make('Новость активна', 'is_active')->updateOnPreview()
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

//    protected function itemsComponent(iterable $items, Fields $fields): MoonShineRenderable
//    {
//        return CardsBuilder::make($items)
//            ->fields($fields)
//            ->title('title')
//            ->cast($this->getResource()->getModelCast())
//            ->buttons([
//                ActionButton::make('Delete'),
//            ]);
//    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Lead;

use App\MoonShine\Resources\Lead\LeadContentResource;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\Field;
use MoonShine\Fields\File;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\MoonShineRequest;
use MoonShine\Pages\Crud\FormPage;
use Throwable;

class LeadFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     * @throws Throwable
     */
    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Text::make('Название', 'title'),
                ])->columnSpan(8),
                Column::make([
                    Date::make('Дата публикации', 'date'),
                    Switcher::make('Новость активна', 'is_active'),
                ])->columnSpan(4)
            ]),
            Block::make([
                TinyMce::make('Текст новости', 'content'),
            ]),
            Divider::make(),
            Grid::make([
                Column::make([
                    Block::make([
                        Image::make('Фотография', 'image')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->dir('lead/images')
                            ->removable()
                    ])
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        File::make('Видео', 'video')
                            ->allowedExtensions(['mp4'])
                            ->disableDownload()
                            ->dir('lead/videos')->removable()


                    ])
                ])->columnSpan(6)
            ])
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

    /**
     * @throws Throwable
     */
    public function getTextBlock(MoonShineRequest $request)
    {
        Json::make('Текст', 'contents')
            ->asRelation(new LeadContentResource())
            ->fields([
                TinyMce::make('', 'content')
            ])
            ->creatable(
                button: ActionButton::make('New', '#', ['id' => 'add'])->primary()->method(
                    'updateSomething',
                    params: ['resourceItem' => $this->getResource()->getItemID()]
                )
            )
            ->removable();
    }
}

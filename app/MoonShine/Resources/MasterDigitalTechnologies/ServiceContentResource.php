<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\Models\MDT\ServiceContent;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Collapse;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Grid;
use MoonShine\Enums\ClickAction;
use MoonShine\Fields\Field;
use MoonShine\Fields\Fields;
use MoonShine\Fields\File;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Json;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<ServiceContent>
 */
class ServiceContentResource extends ModelResource
{
    protected string $model = ServiceContent::class;

    protected string $title = 'Контент';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            Grid::make([
                ID::make()->sortable()->hideOnIndex(),
                Column::make([
                    Block::make([
                        Text::make('Название', 'name')->required(),
                        TinyMce::make('Описание', 'description')
                        ->hideOnIndex(),
                        File::make('Видео', 'video')
                            ->dir('mdt/video/videos')
                            ->allowedExtensions(['mp4'])
                            ->removable()
                            ->disableDownload(),
                        Image::make('Preview')
                            ->dir('mdt/video/preview')
                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                            ->removable()
                    ]),
                ])
                    ->columnSpan(8),
                Column::make([
                    Block::make([
//                        Select::make('Услуга', 'service_id')
//                            ->options(
//                                Service::pluck('name', 'id')->toArray()
//                            )
//                            ->required(),


                    BelongsTo::make('Service')
                        ->required(),
                        Divider::make(),
                    BelongsTo::make('Категория', 'category', resource: new CategoryResource())



//                        Select::make('Категория', 'category_id')
//                            ->options(
//                                Category::pluck('name', 'id')->toArray()
//                            )
//                            ->required()
//                        ->async('/search'),


//                        Select::make('Категория', 'category_id')
//                            ->reactive(function(Fields $fields, ?string $value, Field $field, array $values): Fields {
//                                $field->setValue($value);
//
//                                return tap($fields, static fn ($fields) =>
//                                $fields
//                                    ->findByColumn('service_id')
//                                    ?->options(
//                                        Category::where('service_id', $value)
//                                            ->get()
//                                            ->pluck('name', 'id')
//                                            ->toArray()
//                                    )
//                                );
//                            })
//                            ->required()

//                            ->asyncSearch(
//                                'name',
//                                asyncSearchQuery: function (Builder $query, Request $request): Builder {
//                                    return $query->where('service_id', $request->get('service_id'));
//                                },
//                                replaceQuery: true
//                            )
                    ]),
                    Divider::make(),
                        Block::make([
                            Image::make('Фото', 'image')
                                ->dir('mdt/images')
                                ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                ->removable()
                                ->required()
                        ])
                ])
                    ->columnSpan(4),
            ]),

            Collapse::make('Добавить фото', [
                Block::make([
                    Json::make('Фото', 'images')
                        ->asRelation(new ServiceContentImageResource())
                        ->fields([
                            Grid::make([
                                Column::make([
                                    Block::make([
                                        Image::make('', 'image')
                                            ->allowedExtensions(['png', 'jpg', 'jpeg'])
                                            ->dir('lead/images')
                                            ->removable()
                                            ->hideOnIndex(),
                                        Text::make('', 'name')
                                            ->hideOnIndex()
                                            ->placeholder('Добавьте название'),
                                    TinyMce::make('Описание', 'description')
                                        ->hideOnIndex()
                                ])
                            ])
                        ])
                    ])->removable()
                    ])
                ])

        ];
    }

    /**
     * @param ServiceContent $item
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

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\Models\MDT\ServiceContent;
use App\MoonShine\Pages\ServiceContent\ServiceContentDetailPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentFormPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentIndexPage;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Fields\Select;

/**
 * @extends ModelResource<ServiceContent, ServiceContentIndexPage, ServiceContentFormPage, ServiceContentDetailPage>
 */
class ServiceContentResource extends ModelResource
{
    protected string $model = ServiceContent::class;

    protected string $title = 'Контент';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    protected int $itemsPerPage = 10;

    /**
     * @return Page
     */
    protected function pages(): array
    {
        return [
            ServiceContentIndexPage::class,
            ServiceContentFormPage::class,
            ServiceContentDetailPage::class,
        ];
    }

    /**
     * @param ServiceContent $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    public function filters(): array
    {
        return [
             Select::make('Поиск по услуге', 'service_id')
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
                        Divider::make(),
                        Select::make('Поиск по категории', 'category_id')
                            ->nullable()
                            ->options(Category::query()->get()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->nullable(),
        ];
    }
}

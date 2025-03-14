<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\ServiceContent;
use App\MoonShine\Pages\ServiceContent\ServiceContentDetailPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentFormPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentIndexPage;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;

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
            BelongsTo::make('Поиск по услуге', 'service', resource: ServiceResource::class),
            BelongsTo::make('Поиск по категории', 'category', resource: CategoryResource::class)->nullable()
        ];
    }
}

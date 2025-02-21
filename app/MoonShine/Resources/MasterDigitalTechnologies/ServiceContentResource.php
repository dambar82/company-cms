<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MasterDigitalTechnologies;

use App\Models\MDT\ServiceContent;
use App\MoonShine\Pages\ServiceContent\ServiceContentDetailPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentPEditPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentFormPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentIndexPage;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Enums\ClickAction;
use MoonShine\Enums\PageType;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Pages\Page;
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

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return Page
     */
    public function pages(): array
    {
        return [
            ServiceContentIndexPage::make($this->title()),
            ServiceContentFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ServiceContentDetailPage::make(__('moonshine::ui.show')),
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

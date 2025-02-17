<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\MoonShine\Pages\Lead\LeadEditPage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;
use App\MoonShine\Pages\Lead\LeadIndexPage;
use App\MoonShine\Pages\Lead\LeadFormPage;
use App\MoonShine\Pages\Lead\LeadDetailPage;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Buttons\EditButton;
use MoonShine\Enums\ClickAction;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Resources\ModelResource;
use MoonShine\Pages\Page;

/**
 * @extends ModelResource<Lead>
 */
class LeadResource extends ModelResource
{
    protected string $model = Lead::class;

    protected string $title = 'Вести';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    /**
     * @return list<Page>
     */
    public function pages(): array
    {
        return [
            LeadIndexPage::make($this->title()),
            LeadFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            LeadEditPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            LeadDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    /**
     * @param Lead $item
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

    public function getEditButton(?string $componentName = null, bool $isAsync = false): ActionButton
    {
        $action = fn ($data): string => $this->formPageUrl($data);

        if ($this->isEditInModal()) {
            $action = fn ($data): string => $this->formPageUrl(
                $data,
                params: array_filter([
                    '_component_name' => $componentName ?? $this->listComponentName(),
                    '_async_form' => $isAsync,
                    'page' => $isAsync ? request()->input('page') : null,
                    'sort' => $isAsync ? request()->input('sort') : null,
                ]),
                fragment: 'crud-form'
            );
        }

        return ActionButton::make(
            '',
            url: $action
        )

            ->primary()
            ->icon('heroicons.outline.pencil')
            ->canSee(
                fn (?Model $item): bool => ! is_null($item) && in_array('update', $this->getActiveActions())
                    && $this->setItem($item)->can('update')
            )
            ->customAttributes(['class' => 'edit-button'])
            ->showInLine();
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\News;

use App\Models\Lead;
use App\Models\News;
use App\MoonShine\Pages\News\NewsDetailPage;
use App\MoonShine\Pages\News\NewsFormPage;
use App\MoonShine\Pages\News\NewsIndexPage;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Enums\ClickAction;
use MoonShine\Enums\PageType;
use MoonShine\Handlers\ExportHandler;
use MoonShine\Handlers\ImportHandler;
use MoonShine\Pages\Page;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Lead>
 */
class NewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости';

    protected string $sortDirection = 'ASC';

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::INDEX;

    /**
     * @return Page
     */
    public function pages(): array
    {
        return [
            NewsIndexPage::make($this->title()),
            NewsFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add'),
            ),
            NewsDetailPage::make(__('moonshine::ui.show')),
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
}

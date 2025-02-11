<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\AbubakirovImageResource;
use App\MoonShine\Resources\ProjectResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Menu\MenuElement;
use MoonShine\Pages\Page;
use Closure;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    /**
     * @return list<ResourceContract>
     */
    protected function resources(): array
    {
        return [];
    }

    /**
     * @return list<Page>
     */
    protected function pages(): array
    {
        return [];
    }

    /**
     * @return Closure|list<MenuElement>
     */
    protected function menu(): array
    {
        return [
            MenuItem::make('Проекты', new ProjectResource()),
           MenuGroup::make('Абубакиров', [
               MenuItem::make('Фотогалереи', new AbubakirovImageGalleryResource())->icon('heroicons.outline.photo'),
               MenuItem::make('Фотографии', new AbubakirovImageResource())->icon('heroicons.photo')
           ])->icon('heroicons.inbox-stack'),
        ];
    }

    /**
     * @return Closure|array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}

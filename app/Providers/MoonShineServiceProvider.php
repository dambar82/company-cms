<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Abubakirov\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoGalleryResource;
use App\MoonShine\Resources\Amina\AminaAudioResource;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use App\MoonShine\Resources\Amina\AminaVideoGalleryResource;
use App\MoonShine\Resources\LeadResource;
use App\MoonShine\Resources\LeadResourceOld;
use App\MoonShine\Resources\MasterDigitalTechnologies\MDTImageGalleryResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\MDTVideoGalleryResource;
use App\MoonShine\Resources\ProjectResource;
use Closure;
use MoonShine\Contracts\Resources\ResourceContract;
use MoonShine\Menu\MenuDivider;
use MoonShine\Menu\MenuElement;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Pages\Page;
use MoonShine\Providers\MoonShineApplicationServiceProvider;

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
            MenuDivider::make(),
           MenuGroup::make('Абубакиров', [
               MenuItem::make('Фотогалереи', new AbubakirovImageGalleryResource())->icon('heroicons.outline.photo'),
               MenuItem::make('Видеогалереи', new AbubakirovVideoGalleryResource())->icon('heroicons.outline.video-camera'),
           ])->icon('heroicons.inbox-stack'),
            MenuGroup::make('Амина', [
                MenuItem::make('Новости', new AminaNewsResource())->icon('heroicons.newspaper'),
                MenuItem::make('Аудио', new AminaAudioResource())->icon('heroicons.speaker-wave'),
                MenuItem::make('Видео', new AminaVideoGalleryResource())->icon('heroicons.outline.video-camera'),
            ])->icon('heroicons.inbox-stack'),
            MenuGroup::make('Мастер Цифровых Технологий', [
                MenuItem::make('Услуги', new MDTImageGalleryResource())->icon('heroicons.outline.wrench-screwdriver

'),
                MenuItem::make('Видео', new MDTVideoGalleryResource())->icon('heroicons.outline.video-camera'),
            ])->icon('heroicons.inbox-stack'),
            MenuDivider::make(),
           // MenuItem::make('Вести', new LeadResourceOld())->icon('heroicons.outline.newspaper'),
         //   MenuDivider::make(),
            MenuItem::make('Вести', new LeadResource())->icon('heroicons.outline.newspaper'),
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

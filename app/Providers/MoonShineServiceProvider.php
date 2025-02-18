<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\Lead\LeadEditPage;
use App\MoonShine\Resources\Abubakirov\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoGalleryResource;
use App\MoonShine\Resources\Amina\AminaAudioResource;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use App\MoonShine\Resources\Amina\AminaVideoGalleryResource;
use App\MoonShine\Resources\Lead\LeadResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\MDTImageGalleryResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\MDTVideoGalleryResource;
use App\MoonShine\Resources\ProjectResource;
use App\MoonShine\Resources\Quiz\QuestionResource;
use App\MoonShine\Resources\Quiz\QuizResource;
use App\MoonShine\Resources\Quiz\ResultResource;
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
        return [
            new LeadEditPage()
        ];
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
                MenuItem::make('Услуги', new MDTImageGalleryResource())->icon('heroicons.outline.wrench-screwdriver'),
                MenuItem::make('Видео', new MDTVideoGalleryResource())->icon('heroicons.outline.video-camera'),
            ])->icon('heroicons.inbox-stack'),
            MenuDivider::make(),
            MenuItem::make('Новости', new LeadResource())->icon('heroicons.outline.newspaper'),
            MenuDivider::make(),
            MenuGroup::make('Викторины', [
            MenuItem::make('Викторины', new QuizResource())->icon('heroicons.outline.academic-cap'),
            MenuItem::make('Вопросы', new QuestionResource())->icon('heroicons.outline.question-mark-circle'),
            MenuItem::make('Результаты', new ResultResource())->icon('heroicons.outline.arrow-down-circle'),
            ])->icon('heroicons.academic-cap')
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

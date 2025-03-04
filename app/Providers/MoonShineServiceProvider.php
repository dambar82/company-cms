<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\Abubakirov\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoGalleryResource;
use App\MoonShine\Resources\Amina\AminaAudioResource;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use App\MoonShine\Resources\Amina\AminaVideoGalleryResource;
use App\MoonShine\Resources\BannerResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\RequestResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\PostResource;
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
                MenuItem::make('Услуги', new ServiceResource())->icon('heroicons.outline.wrench-screwdriver'),
                MenuItem::make('Контент', new ServiceContentResource())->icon('heroicons.outline.arrows-pointing-in'),
                MenuItem::make('Заявки', new RequestResource())->icon('heroicons.outline.inbox-arrow-down')
            ])->icon('heroicons.inbox-stack'),
            MenuDivider::make(),
            MenuItem::make('Новости', new NewsResource())->icon('heroicons.outline.newspaper'),
            MenuDivider::make(),
            MenuGroup::make('Викторины', [
            MenuItem::make('Викторины', new QuizResource())->icon('heroicons.outline.academic-cap'),
            MenuItem::make('Вопросы', new QuestionResource())->icon('heroicons.outline.question-mark-circle'),
            MenuItem::make('Результаты', new ResultResource())->icon('heroicons.outline.arrow-down-circle'),
            ])->icon('heroicons.academic-cap'),
            MenuDivider::make(),
            MenuItem::make('Баннеры', new BannerResource())->icon('heroicons.outline.clipboard-document-list'),
            MenuDivider::make(),
            MenuItem::make('Страницы', new PageResource())->icon('heroicons.outline.book-open'),
            MenuDivider::make(),
            MenuItem::make('Посты', new PostResource())->icon('heroicons.outline.arrow-up-on-square-stack'),
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

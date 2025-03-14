<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Abubakirov\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoGalleryResource;
use App\MoonShine\Resources\Amina\AminaAudioResource;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use App\MoonShine\Resources\Amina\AminaVideoResource;
use App\MoonShine\Resources\BannerResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\RequestResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\PostResource;
use App\MoonShine\Resources\ProjectResource;
use App\MoonShine\Resources\Quiz\QuestionResource;
use App\MoonShine\Resources\Quiz\QuizResource;
use App\MoonShine\Resources\Quiz\ResultResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\CompactLayout;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\{Layout\Layout};

final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make('Проекты', ProjectResource::class)->icon('server-stack'),
            MenuDivider::make(),
            MenuGroup::make('Абубакиров', [
                MenuItem::make('Фотогалереи', AbubakirovImageGalleryResource::class)->icon('photo'),
                MenuItem::make('Видеогалереи', AbubakirovVideoGalleryResource::class)->icon('videcamera'),
            ])->icon('s.inbox-stack'),
            MenuGroup::make('Амина', [
                MenuItem::make('Новости', AminaNewsResource::class)->icon('newspaper'),
                MenuItem::make('Аудио', AminaAudioResource::class)->icon('speaker-wave'),
                MenuItem::make('Видео', AminaVideoResource::class)->icon('videcamera'),
            ])->icon('s.inbox-stack'),
            MenuGroup::make('Мастер Цифровых Технологий', [
                MenuItem::make('Услуги', ServiceResource::class)->icon('wrench-screwdriver'),
                MenuItem::make('Контент', ServiceContentResource::class)->icon('arrows-pointing-in'),
                MenuItem::make('Заявки', RequestResource::class)->icon('inbox-arrow-down'),
            ])->icon('s.inbox-stack'),
            MenuDivider::make(),
            MenuItem::make('Новости', NewsResource::class)->icon('newspaper'),
            MenuDivider::make(),
            MenuGroup::make('Викторины', [
                MenuItem::make('Викторины', QuizResource::class)->icon('academic-cap'),
                MenuItem::make('Вопросы', QuestionResource::class)->icon('question-mark-circle'),
                MenuItem::make('Результаты', ResultResource::class)->icon('arrow-down-circle'),
            ])->icon('s.academic-cap'),
            MenuDivider::make(),
            MenuItem::make('Баннеры', BannerResource::class)->icon('clipboard-document-list'),
            MenuDivider::make(),
            MenuItem::make('Страницы', PageResource::class)->icon('book-open'),
            MenuDivider::make(),
            MenuItem::make('Посты', PostResource::class)->icon('arrow-up-on-square-stack'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}

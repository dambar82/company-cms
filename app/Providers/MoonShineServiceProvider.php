<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\News\NewsDetailPage;
use App\MoonShine\Pages\News\NewsFormPage;
use App\MoonShine\Pages\News\NewsIndexPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentDetailPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentFormPage;
use App\MoonShine\Pages\ServiceContent\ServiceContentIndexPage;
use App\MoonShine\Resources\Abubakirov\AbubakirovImageGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovImageResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoGalleryResource;
use App\MoonShine\Resources\Abubakirov\AbubakirovVideoResource;
use App\MoonShine\Resources\Amina\AminaAudioResource;
use App\MoonShine\Resources\Amina\AminaNewsResource;
use App\MoonShine\Resources\Amina\AminaVideoResource;
use App\MoonShine\Resources\BannerResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\CategoryResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\RequestResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentImageResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceContentResource;
use App\MoonShine\Resources\MasterDigitalTechnologies\ServiceResource;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\News\NewsContentResource;
use App\MoonShine\Resources\News\NewsResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\PostResource;
use App\MoonShine\Resources\ProjectResource;
use App\MoonShine\Resources\Quiz\AnswerResource;
use App\MoonShine\Resources\Quiz\QuestionResource;
use App\MoonShine\Resources\Quiz\QuizResource;
use App\MoonShine\Resources\Quiz\ResultResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                ProjectResource::class,
                AbubakirovImageGalleryResource::class,
                AbubakirovVideoGalleryResource::class,
                AminaNewsResource::class,
                AminaAudioResource::class,
                ServiceResource::class,
                ServiceContentResource::class,
                RequestResource::class,
                NewsResource::class,
                QuizResource::class,
                QuestionResource::class,
                ResultResource::class,
                BannerResource::class,
                PageResource::class,
                PostResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                AbubakirovImageResource::class,
                AbubakirovVideoResource::class,
                AminaVideoResource::class,
                CategoryResource::class,
                ServiceContentImageResource::class,
                NewsContentResource::class,
                AnswerResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                NewsDetailPage::class,
                NewsFormPage::class,
                NewsIndexPage::class,
                ServiceContentDetailPage::class,
                ServiceContentFormPage::class,
                ServiceContentIndexPage::class
            ])
        ;
    }
}

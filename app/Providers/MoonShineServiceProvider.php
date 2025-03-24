<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use MoonShine\AssetManager\Js;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     *
     */
    public function boot(CoreContract $core): void
    {
        $core->autoload();

        moonShineAssets()->add([
            new Js(Vite::asset('resources/js/app.js'))
        ]);
    }
}

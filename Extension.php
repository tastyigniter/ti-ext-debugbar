<?php

namespace Igniter\Debugbar;

use Admin\Facades\AdminAuth;
use DebugBar\DebugBar;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use System\Classes\BaseExtension;

/**
 * Debugbar Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        if (!config('app.debug', FALSE) OR !$this->app->hasDatabase())
            return;

        $configPath = __DIR__.'/config/ide-helper.php';
        $this->mergeConfigFrom($configPath, 'ide-helper');

        $configPath = __DIR__.'/config/debugbar.php';
        $this->app['config']->set('debugbar', require $configPath);

        $configPath = __DIR__.'/config/querydetector.php';
        $this->app['config']->set('querydetector', require $configPath);

        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('json', 'text');

        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

        // Register alias
        $alias = AliasLoader::getInstance();
        $alias->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);

        Event::listen('router.beforeRoute', function ($url, $router) {
            if (!AdminAuth::check()) {
                Debugbar::disable();
            }
        });

        $this->app->register(\BeyondCode\QueryDetector\QueryDetectorServiceProvider::class);
    }
}

<?php

namespace Igniter\Debugbar;

use AdminAuth;
use Debugbar;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\DB;
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
        $configPath = __DIR__.'/config/ide-helper.php';
        $this->mergeConfigFrom($configPath, 'ide-helper');

        $configPath = __DIR__.'/config/debugbar.php';
        $this->app['config']->set('debugbar', require $configPath);

        if ($this->app->environment() !== 'production') {
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
        }
    }
}

<?php

namespace Igniter\Debugbar;

use Admin\Facades\AdminAuth;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Foundation\AliasLoader;
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
        if (!config('app.debug', false) || !$this->app->hasDatabase())
            return;

        $configPath = __DIR__.'/config/debugbar.php';
        $this->app['config']->set('debugbar', require $configPath);

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

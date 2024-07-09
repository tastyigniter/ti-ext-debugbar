<?php

namespace Igniter\Debugbar;

use Barryvdh\Debugbar\Facades\Debugbar;
use Igniter\Flame\Igniter;
use Igniter\System\Classes\BaseExtension;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Facades\Event;

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
        if (!config('app.debug', false) || !Igniter::hasDatabase()) {
            return;
        }

        $configPath = __DIR__.'/../config/debugbar.php';
        $this->app['config']->set('debugbar', require $configPath);

        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Clockwork\Support\Laravel\ClockworkServiceProvider::class);

        Event::listen('router.beforeRoute', function($url, $router) {
            if (!AdminAuth::check()) {
                Debugbar::disable();
            }
        });
    }
}

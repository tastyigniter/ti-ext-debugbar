<?php

namespace Igniter\Debugbar;

use Barryvdh\Debugbar\Facades\Debugbar;
use Igniter\Flame\Support\Facades\Igniter;
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
        if (!Igniter::hasDatabase()) {
            return;
        }

        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Clockwork\Support\Laravel\ClockworkServiceProvider::class);

        $this->mergeIdeHelperConfig();

        Event::listen('router.beforeRoute', function($url, $router) {
            if (!AdminAuth::check()) {
                Debugbar::disable();
            }
        });
    }

    protected function mergeIdeHelperConfig(): void
    {
        $config = $this->app['config'];

        $configPath = __DIR__.'/../config/ide-helper.php';
        $config->set('ide-helper', array_merge_deep(
            $config->get('ide-helper', []), require $configPath,
        ));
    }
}

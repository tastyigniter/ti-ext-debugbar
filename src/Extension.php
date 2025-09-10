<?php

declare(strict_types=1);

namespace Igniter\Debugbar;

use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Classes\BaseExtension;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Support\Facades\Event;
use Override;

/**
 * Debugbar Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Register method, called when the extension is first registered.
     */
    #[Override]
    public function register(): void
    {
        if (!Igniter::hasDatabase()) {
            return;
        }

        $this->app->register(IdeHelperServiceProvider::class);
        $this->app->register(ServiceProvider::class);
        $this->app->register(ClockworkServiceProvider::class);

        $this->mergeIdeHelperConfig();

        Event::listen('router.beforeRoute', function($url, $router): void {
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

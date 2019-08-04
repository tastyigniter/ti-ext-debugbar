<?php namespace Igniter\Debugbar;

use AdminAuth;
use App;
use Debugbar;
use Event;
use Illuminate\Foundation\AliasLoader;
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

        if (App::environment() !== 'production')
            App::register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        App::register(\Barryvdh\Debugbar\ServiceProvider::class);

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

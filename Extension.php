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
     * Returns information about this extension.
     *
     * @return array
     */
    public function extensionMeta()
    {
        return [
            'name' => 'Debugbar',
            'author' => 'SamPoyigi',
            'description' => 'Easily see what\'s going on under the hood of your TastyIgniter application.',
            'icon' => 'fa-bug',
            'version' => '1.0.0'
        ];
    }

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

    /**
     * Initialize method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
    }
}

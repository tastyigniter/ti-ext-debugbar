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
            'name'        => 'Debugbar',
            'author'      => 'IgniterLab',
            'description' => 'No description provided yet...',
            'icon'        => 'fa-plug',
            'version'     => '1.0.0'
        ];
    }

    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/config/ide-helper.php';
        $this->mergeConfigFrom($configPath, 'ide-helper');

        if (App::environment() !== 'production')
            App::register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        $configPath = __DIR__ . '/config/debugbar.php';
        $this->app['config']->set('debugbar', require $configPath);

        App::register(\Barryvdh\Debugbar\ServiceProvider::class);

        // Register alias
        $alias = AliasLoader::getInstance();
        $alias->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);

//        $this->app['Illuminate\Contracts\Http\Kernel']->pushMiddleware('\Igniter\Debugbar\Middleware\Debugbar');

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
    public function initialize()
    {
    }
}

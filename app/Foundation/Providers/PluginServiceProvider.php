<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Foundation\Providers;

use CachetHQ\Cachet\Services\Plugins\Container;
use CachetHQ\Cachet\Services\Plugins\Contracts\Container as ContainerContract;
use CachetHQ\Cachet\Services\Plugins\Contracts\Finder as FinderContract;
use CachetHQ\Cachet\Services\Plugins\Contracts\Manager as ManagerContract;
use CachetHQ\Cachet\Services\Plugins\Contracts\Parser as ParserContract;
use CachetHQ\Cachet\Services\Plugins\Contracts\Provider as ProviderContract;
use CachetHQ\Cachet\Services\Plugins\Finder;
use CachetHQ\Cachet\Services\Plugins\Manager;
use CachetHQ\Cachet\Services\Plugins\Parser;
use CachetHQ\Cachet\Services\Plugins\Provider;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Illuminate\Support\ServiceProvider;

/**
 * This is the plugin service provider.
 *
 * @author Connor S. Parks <contact@connorvg.tv>
 */
class PluginServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        // ...
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFinder();
        $this->registerParser();
        $this->registerContainer();
        $this->registerManager();
        $this->registerProvider();
        $this->registerPlugins();
    }

    /**
     * Register the plugin finder.
     *
     * @return void
     */
    protected function registerFinder()
    {
        $this->app->singleton(FinderContract::class, function (Application $app) {
            $files = $app->make(Filesystem::class)->drive('plugins');

            return new Finder($files);
        });
    }

    /**
     * Register the plugin parser.
     *
     * @return void
     */
    protected function registerParser()
    {
        $this->app->singleton(ParserContract::class, function (Application $app) {
            $files = $app->make(Filesystem::class)->drive('plugins');

            return new Parser($files);
        });
    }

    /**
     * Register the plugin container.
     *
     * @return void
     */
    protected function registerContainer()
    {
        $this->app->singleton(ContainerContract::class, function (Application $app) {
            $finder = $app->make(FinderContract::class);
            $parser = $app->make(ParserContract::class);

            $plugins = $finder->retrieve();
            $plugins = $parser->from($plugins);

            return new Container($plugins);
        });
    }

    /**
     * Register the plugin manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton(ManagerContract::class, function (Application $app) {
            $container = $app->make(ContainerContract::class);

            return new Manager($container);
        });
    }

    /**
     * Register the plugin provider.
     *
     * @return void
     */
    protected function registerProvider()
    {
        $this->app->singleton(ProviderContract::class, function (Application $app) {
            return new Provider($app);
        });
    }

    /**
     * Register the plugins.
     *
     * @return void
     */
    protected function registerPlugins()
    {
        $this->app->call(ProviderContract::class.'@register');
    }
}

<?php

namespace Mcms\Eshop;


use Mcms\Eshop\StartUp\RegisterAdminPackage;
use Mcms\Eshop\StartUp\RegisterEvents;
use Mcms\Eshop\StartUp\RegisterFacades;
use Mcms\Eshop\StartUp\RegisterMiddleware;
use Mcms\Eshop\StartUp\RegisterServiceProviders;
use Mcms\Eshop\StartUp\RegisterSettingsManager;
use Mcms\Eshop\StartUp\RegisterWidgets;
use Illuminate\Support\ServiceProvider;
use \App;
use \Installer, \Widget;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Routing\Router;

class EshopServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        \Mcms\Eshop\Console\Commands\Install::class,
        \Mcms\Eshop\Console\Commands\RefreshAssets::class,
    ];

    public $packageName = 'mcms-eshop';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(DispatcherContract $events, GateContract $gate, Router $router)
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('eshop.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../database/seeds/' => database_path('seeds')
        ], 'seeds');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/mcms/eshop'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/mcms/eshop'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/mcms/eshop'),
        ], 'assets');

        $this->publishes([
            __DIR__ . '/../config/admin.package.json' => storage_path('app/mcms/eshop/admin.package.json'),
        ], 'admin-package');


        if (!$this->app->routesAreCached()) {
            $router->group([
                'middleware' => 'web',
            ], function ($router) {
                require __DIR__.'/Http/routes.php';
            });

            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mcmsEshop');
        }

        /**
         * Register any widgets
         */
        (new RegisterWidgets())->handle();

        /**
         * Register Events
         */
//        parent::boot($events);
        (new RegisterEvents())->handle($this, $events);

        /*
         * Register dependencies
        */
        (new RegisterServiceProviders())->handle();

        /*
         * Register middleware
        */
        (new RegisterMiddleware())->handle($this, $router);


        /**
         * Register admin package
         */
        (new RegisterAdminPackage())->handle($this);

        (new RegisterSettingsManager())->handle($this);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        /*
        * Register Commands
        */
        $this->commands($this->commands);

        /**
         * Register Facades
         */
        (new RegisterFacades())->handle($this);


        /**
         * Register installer
         */
        Installer::register(\Mcms\Eshop\Installer\Install::class);

    }
}

<?php namespace Genetsis\Druid;

use Genetsis\Druid\Events\DruidSubscriber;
use Genetsis\Druid\Middleware\Connected;
use Genetsis\Druid\Middleware\UserLogged;
use Genetsis\Druid\ViewComposers\ProfileComposer;
use Genetsis\Identity;

use Illuminate\Support\ServiceProvider;

class DruidServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleRoutes();
        $this->publishResources();

        $this->app['router']->aliasMiddleware('user.connected', Connected::class);
        $this->app['router']->aliasMiddleware('user.logged', UserLogged::class);

        $this->app->make('view')->composer(config('druid_config.config.composer_views'), ProfileComposer::class);

        \Event::subscribe(DruidSubscriber::class);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Druid', function() {
            Identity::init('default', true, config_path('/druid_config/druid.ini'));
        });
    }

    private function handleRoutes() {
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
    }

    private function publishResources() {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../site-config' => config_path('druid_config'),
            ]);
        }
    }
}

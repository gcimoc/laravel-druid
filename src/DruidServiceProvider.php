<?php namespace Genetsis\Druid;

use Cache\Adapter\Apcu\ApcuCachePool;
use Genetsis\core\OAuthConfig;
use Genetsis\Druid\Events\DruidSubscriber;
use Genetsis\Druid\Middleware\Connected;
use Genetsis\Druid\Middleware\PromotionActive;
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->handleRoutes();
        $this->publishResources();

        $this->app['router']->aliasMiddleware('user.connected', Connected::class);
        $this->app['router']->aliasMiddleware('user.logged', PromotionActive::class);

        $this->app->make('view')->composer(config('druid.composer_views'), ProfileComposer::class);

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

            $druid_config = OAuthConfig::init()->setClientId(env('DRUID_ID'))
                ->setClientSecret(env('DRUID_SECRET'))
                ->setEnvironment(env('DRUID_ENVIRONMENT'))
                ->setCallback(env('DRUID_CALLBACK'))
                ->setEntryPoints(array(ENV('DRUID_ENTRYPOINT')))
                ->setCachePath(env('DRUID_CACHEPATH'))
                ->setLogPath(env('DRUID_LOGPATH'))
                ->setLogLevel(env('DRUID_LOGLEVEL'));

            //$options['cache'] = new ApcuCachePool();
            $options['logger'] = app('log')->channel('stack')->getLogger();

            Identity::init($druid_config, true, $options);
        });
    }

    private function handleRoutes() {
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
    }

    private function publishResources() {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/druid_config.php' => config_path('druid.php')
            ], 'config');
        }
    }
}

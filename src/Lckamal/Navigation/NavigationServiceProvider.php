<?php namespace Lckamal\Navigation;

use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../');

        $this->package('lckamal/navigation', 'lckamal/navigation', $path);

        include "{$path}/global.php";
        include "{$path}/events.php";
        include "{$path}/filters.php";
        include "{$path}/routes.php";
        include "{$path}/helpers.php";
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
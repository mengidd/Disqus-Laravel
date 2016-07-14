<?php namespace Mengidd\Disqus\Providers;

use Illuminate\Support\ServiceProvider;
use Mengidd\Disqus\Disqus;

class DisqusServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path('disqus.php')]);
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'disqus');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mengidd.disqus', Disqus::class);
    }

}

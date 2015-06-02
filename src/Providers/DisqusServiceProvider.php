<?php namespace Mengidd\Disqus\Providers;

use Illuminate\Support\ServiceProvider;
use Mengidd\Disqus\Api\Disqus;

class DisqusServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/config.php' => config_path('disqus.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'disqus');
    }

}

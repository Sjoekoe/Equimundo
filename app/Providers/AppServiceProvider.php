<?php namespace EQM\Providers;

use AlgoliaSearch\Client;
use Blade;
use EQM\Core\Search\AlgoliaSearchEngine;
use EQM\Core\Search\SearchEngine;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::setRawTags('{{', '}}');
        Blade::setContentTags('{{{', '}}}');
        Blade::setEscapedContentTags('{{{', '}}}');
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'EQM\Services\Registrar'
        );

        if (! $this->app->environment('testing')) {
            $this->app->singleton(SearchEngine::class, function() {
                return new AlgoliaSearchEngine(
                    new Client(env('ALGOLIA_APP_ID'), env('ALGOLIA_ADMIN_API_KEY'))
                );
            });
        }
    }

}

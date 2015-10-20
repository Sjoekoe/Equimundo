<?php
namespace EQM\Models\Horses;

use EQM\Core\Slugs\SlugCreator;
use Illuminate\Support\ServiceProvider;

class HorseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HorseRepository::class, function() {
            return new EloquentHorseRepository(new EloquentHorse());
        });
    }
}

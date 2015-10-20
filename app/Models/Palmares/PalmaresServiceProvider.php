<?php
namespace EQM\Models\Palmares;

use Illuminate\Support\ServiceProvider;

class PalmaresServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PalmaresRepository::class, function() {
            return new EloquentPalmaresRepository(new EloquentPalmares());
        });
    }
}

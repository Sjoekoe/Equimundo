<?php
namespace EQM\Models\Pedigrees;

use Illuminate\Support\ServiceProvider;

class PedigreeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PedigreeRepository::class, function() {
            return new EloquentPedigreeRepository(new EloquentPedigree());
        });
    }
}

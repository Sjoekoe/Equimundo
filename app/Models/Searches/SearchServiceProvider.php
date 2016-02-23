<?php
namespace EQM\Models\Searches;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SearchRepository::class, function() {
            return new EloquentSearchRepository(new EloquentSearch());
        });
    }
}

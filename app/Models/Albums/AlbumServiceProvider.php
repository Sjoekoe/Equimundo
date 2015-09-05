<?php
namespace EQM\Models\Albums;

use Illuminate\Support\ServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AlbumRepository::class, function() {
            return new EloquentAlbumRepository(new EloquentAlbum());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [AlbumRepository::class];
    }
}

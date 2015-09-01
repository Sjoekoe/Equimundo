<?php
namespace EQM\Models\Albums;

use Illuminate\Support\ServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Album::class, function() {
            return new EloquentAlbum();
        });

        $this->app->singleton(AlbumRepository::class, function() {
            return new EloquentAlbumRepository(new EloquentAlbum());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [Album::class, AlbumRepository::class];
    }
}

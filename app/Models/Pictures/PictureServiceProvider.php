<?php
namespace EQM\Models\Pictures;

use Illuminate\Support\ServiceProvider;

class PictureServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PictureRepository::class, function() {
            return new EloquentPictureRepository(new EloquentPicture());
        });
    }
}

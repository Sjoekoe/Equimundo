<?php
namespace EQM\Core\Factories;

use Illuminate\Support\ServiceProvider;

class ModelFactoryServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        return $this->app->bind(ModelFactory::class, EloquentModelFactory::class);
    }

    public function provides()
    {
        return [
            ModelFactory::class,
        ];
    }
}

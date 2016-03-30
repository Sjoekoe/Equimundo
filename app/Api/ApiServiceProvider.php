<?php
namespace EQM\Api;

use Dingo\Api\Transformer\Adapter\Fractal;
use Dingo\Api\Transformer\Factory;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app[Factory::class]->setAdapter(function ($app) {
            return new Fractal(new Manager(), 'include', ',');
        });
    }
}

<?php
namespace EQM\Models\Addresses;

use Illuminate\Support\ServiceProvider;

class AddressServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(AddressRepository::class, function() {
            return new EloquentAddressRepository(new EloquentAddress());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [AddressRepository::class];
    }
}

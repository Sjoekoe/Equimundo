<?php
namespace EQM\Models\Addresses;

use Illuminate\Support\ServiceProvider;

class AddressServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Address::class, function() {
            return new EloquentAddress();
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [Address::class];
    }
}

<?php
namespace EQM\Models\Advertising;

use EQM\Models\Advertising\Contacts\AdvertisingContactRepository;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContactRepository;
use Illuminate\Support\ServiceProvider;

class AdvertisingServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    public function register()
    {
        $this->app->singleton(AdvertisingContactRepository::class, function() {
            return new EloquentAdvertisingContactRepository(new EloquentAdvertisingContact());
        });
    }
    
    public function provides()
    {
        return [
            AdvertisingContactRepository::class,
        ];
    }
}

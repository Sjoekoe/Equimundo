<?php
namespace EQM\Models\Advertising;

use EQM\Models\Advertising\Advertisements\AdvertisementRepository;
use EQM\Models\Advertising\Advertisements\EloquentAdvertisement;
use EQM\Models\Advertising\Advertisements\EloquentAdvertisementRepository;
use EQM\Models\Advertising\Companies\AdvertisingCompanyRepository;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompany;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompanyRepository;
use EQM\Models\Advertising\Contacts\AdvertisingContactRepository;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContactRepository;
use Illuminate\Support\ServiceProvider;

class AdvertisingServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    public function register()
    {
        $this->app->singleton(AdvertisingContactRepository::class, function() {
            return new EloquentAdvertisingContactRepository(new EloquentAdvertisingContact());
        });

        $this->app->singleton(AdvertisingCompanyRepository::class, function() {
            return new EloquentAdvertisingCompanyRepository(new EloquentAdvertisingCompany());
        });
        
        $this->app->singleton(AdvertisementRepository::class, function() {
            return new EloquentAdvertisementRepository(new EloquentAdvertisement());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            AdvertisingContactRepository::class,
            AdvertisingCompanyRepository::class,
            AdvertisementRepository::class,
        ];
    }
}

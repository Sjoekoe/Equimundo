<?php
namespace EQM\Models\Companies;

use EQM\Models\Companies\Horses\CompanyHorseRepository;
use EQM\Models\Companies\Horses\EloquentCompanyHorse;
use EQM\Models\Companies\Horses\EloquentCompanyHorseRepository;
use EQM\Models\Companies\Users\CompanyUserRepository;
use EQM\Models\Companies\Users\EloquentCompanyUser;
use EQM\Models\Companies\Users\EloquentCompanyUserRepository;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
    
    public function register()
    {
        $this->app->singleton(CompanyRepository::class, function() {
            return new EloquentCompanyRepository(new EloquentCompany());
        });
        
        $this->app->singleton(CompanyUserRepository::class, function() {
            return new EloquentCompanyUserRepository(new EloquentCompanyUser());
        });
        
        $this->app->singleton(CompanyHorseRepository::class, function() {
            return new EloquentCompanyHorseRepository(new EloquentCompanyHorse());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            CompanyRepository::class,
            CompanyUserRepository::class,
            CompanyHorseRepository::class,
        ];
    }
}

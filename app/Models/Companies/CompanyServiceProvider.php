<?php
namespace EQM\Models\Companies;

use EQM\Models\Companies\Users\CompanyUserRepository;
use EQM\Models\Companies\Users\EloquentCompanyUser;
use EQM\Models\Companies\Users\EloquentCompanyUserRepository;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    public function register()
    {
        $this->app->singleton(CompanyRepository::class, function() {
            return new EloquentCompanyRepository(new EloquentCompany());
        });
        
        $this->app->singleton(CompanyUserRepository::class, function() {
            return new EloquentCompanyUserRepository(new EloquentCompanyUser());
        });
    }
    
    public function provides()
    {
        return [
            CompanyRepository::class,
        ];
    }
}

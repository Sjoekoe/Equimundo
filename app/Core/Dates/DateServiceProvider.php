<?php
namespace EQM\Core\Dates;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DateTranslator::class, JensSegersDate::class);
    }
}

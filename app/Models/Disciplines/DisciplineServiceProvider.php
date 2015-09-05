<?php
namespace EQM\Models\Disciplines;

use Illuminate\Support\ServiceProvider;

class DisciplineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DisciplineRepository::class, function() {
            return new EloquentDisciplineRepository(new EloquentDiscipline());
        });
    }
}

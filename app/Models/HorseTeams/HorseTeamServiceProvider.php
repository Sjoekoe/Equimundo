<?php
namespace EQM\Models\HorseTeams;

use Illuminate\Support\ServiceProvider;

class HorseTeamServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HorseTeamRepository::class, function() {
            return new EloquentHorseTeamRepository(new EloquentHorseTeam());
        });
    }
}

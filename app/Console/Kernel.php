<?php namespace EQM\Console;

use EQM\Console\Commands\AlgoliaIndexer;
use EQM\Console\Commands\DropTables;
use EQM\Console\Commands\SendReminderEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AlgoliaIndexer::class,
        SendReminderEmail::class,
        DropTables::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

}

<?php

use Carbon\Carbon;
use EQM\Core\Factories\BuildModels;
use EQM\Core\Factories\ModelFactory;
use EQM\Core\Testing\CreatesModels;
use EQM\Models\Addresses\Address;
use EQM\Models\Advertising\Advertisements\Rectangle;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Companies\Horses\CompanyHorse;
use EQM\Models\Companies\Stable;
use EQM\Models\Companies\Users\Follower;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\CompanyStatus;
use EQM\Models\Statuses\HorseStatus;
use EQM\Models\Users\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use BuildModels, CreatesModels;

    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        $this->modelFactory = $app->make(ModelFactory::class);

        return $app;
    }

    public function setup()
    {
        parent::setUp();

        //$this->artisan('migrate');
    }
}

<?php

use Carbon\Carbon;
use EQM\Core\Factories\BuildModels;
use EQM\Core\Factories\ModelFactory;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use BuildModels;

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

        $this->artisan('migrate:reset');
        $this->artisan('migrate');
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Users\User
     */
    public function createUser(array $attributes = [])
    {
        return $this->modelFactory->create(User::class, array_merge([
            'last_name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john.doe@email.com',
            'language' => 'en',
            'activated' => true,
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
            'country' => 'BE',
            'gender' => 'M',
            'slug' => 'john.doe',
            'unread_notifications' => 0,
            'timezone' => 'Europe/Brussels',
        ], $attributes));
    }

    /**
     * @param $id
     * @return \EQM\Models\Users\User
     */
    protected function findUser($id)
    {
        $users = app(\EQM\Models\Users\UserRepository::class);
        return $users->findById($id);
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Users\User
     */
    public function loginAsUser(array $attributes = [])
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Horses\Horse
     */
    public function createHorse(array $attributes = [])
    {
        return $this->modelFactory->create(Horse::class, array_merge([
            'name' => 'test horse',
            'life_number' => '123456',
            'date_of_birth' => Carbon::now(),
            'slug' => 'test-horse',
            'gender' => Horse::GELDING,
            'color' => Horse::BAY,
            'height' => 5,
            'breed' => Horse::ABTENAUER,
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function createHorseTeam(array $attributes)
    {
        return $this->modelFactory->create(HorseTeam::class, array_merge([
            'type' => HorseTeam::OWNER
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Statuses\Status
     */
    public function createStatus(array $attributes)
    {
        return $this->modelFactory->create(Status::class, array_merge([
            'body' => 'Lorem ipsum dolores est',
            'prefix' => 1
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Notifications\Notification
     */
    public function createNotification(array $attributes)
    {
        return $this->modelFactory->create(Notification::class, array_merge([
            'type' => Notification::STATUS_LIKED,
            'read' => false,
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function createAdvertisingContact(array $attributes = [])
    {
        return $this->modelFactory->create(AdvertisingContact::class, array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'telephone' => '1234'
        ], $attributes));
    }
}

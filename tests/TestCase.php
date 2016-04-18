<?php

use Carbon\Carbon;
use EQM\Core\Factories\BuildModels;
use EQM\Core\Factories\ModelFactory;
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
        return $this->modelFactory->create(HorseStatus::class, array_merge([
            'body' => 'Lorem ipsum dolores est',
            'type' => HorseStatus::TYPE,
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

    /**
     * @param array $attributes
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function createAdvertisingCompany(array $attributes = [])
    {
        return $this->modelFactory->create(AdvertisingCompany::class, array_merge([
            'name' => 'Foo company',
            'tax' => '1234567',
            'telephone' => '1234',
            'email' => 'foo@company.com',
            'address_id' => null,
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Addresses\Address
     */
    public function createAddress(array $attributes = [])
    {
        return $this->modelFactory->create(Address::class, array_merge([
            'street' => 'Foo street',
            'city' => 'Baz City',
            'state' => 'Antwerp',
            'country' => 'BE',
            'zip' => '2000',
            'latitude' => '1234',
            'longitude' => '5678',
        ], $attributes));
    }

    /**
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function createCompleteAdvertisingCompany()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();
        return $this->createAdvertisingCompany([
            'address_id' => $address->id(),
            'adv_contact_id' => $contact->id(),
        ]);
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Advertising\Advertisements\Advertisement
     */
    public function createAdvertisement(array $attributes = [])
    {
        return $this->modelFactory->create(Rectangle::class, array_merge([
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->addDays(30)->endOfDay(),
            'type' => Rectangle::NAME,
            'paid' => true,
            'amount' => 500,
            'clicks' => 1,
            'views' => 2,
            'picture_id' => null,
            'website' => 'http://www.test.com',
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Companies\Company
     */
    public function createCompany(array $attributes = [])
    {
        return $this->modelFactory->create(Stable::class, array_merge([
            'name' => 'Stal de vogelzang',
            'slug' => 'stal-de-vogelzang',
            'type' => Stable::TYPE,
            'address_id' => null,
            'email' => 'company@test.com',
            'website' => 'staldevogelzang.be',
            'about' => 'lorem ipsum',
            'telephone' => '12345'
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Companies\Users\CompanyUser
     */
    public function createCompanyUser(array $attributes = [])
    {
        return $this->modelFactory->create(Follower::class, array_merge([
            'is_admin' => false,
            'type' => Follower::TYPE,
        ], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Companies\Horses\CompanyHorse
     */
    public function createCompanyHorse(array $attributes = [])
    {
        return $this->modelFactory->create(CompanyHorse::class, array_merge([], $attributes));
    }

    /**
     * @param array $attributes
     * @return \EQM\Models\Statuses\CompanyStatus
     */
    public function createCompanyStatus(array $attributes = [])
    {
        return $this->modelFactory->create(CompanyStatus::class, array_merge([
            'body' => 'lorem ipsum',
            'type' => CompanyStatus::TYPE,
            'prefix' => 1,
        ], $attributes));
    }
}

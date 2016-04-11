<?php
namespace EQM\Core\Factories;

use EQM\Models\Addresses\Address;
use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Advertising\Advertisements\EloquentAdvertisement;
use EQM\Models\Advertising\Advertisements\EloquentRectangle;
use EQM\Models\Advertising\Advertisements\Rectangle;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompany;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Statuses\Status;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Factory;

class EloquentModelFactory implements ModelFactory
{
    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    private $factory;

    /**
     * @var array
     */
    private $models = [
        Address::class => EloquentAddress::class,
        Rectangle::class => EloquentRectangle::class,
        AdvertisingCompany::class => EloquentAdvertisingCompany::class,
        AdvertisingContact::class => EloquentAdvertisingContact::class,
        Horse::class => EloquentHorse::class,
        HorseTeam::class => EloquentHorseTeam::class,
        Notification::class => EloquentNotification::class,
        Status::class => EloquentStatus::class,
        User::class => EloquentUser::class,
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $model
     * @param array $attributes
     * @return object
     */
    public function make($model, array $attributes = [])
    {
        return $this->factory->of($this->resolveModel($model))->make($attributes);
    }

    /**
     * @param string $model
     * @param array $attributes
     * @param int $times
     * @return object
     */
    public function create($model, array $attributes = [], $times = 1)
    {
        return $this->factory->of($this->resolveModel($model))->times($times)->create($attributes);
    }

    /**
     * @param string $model
     * @throws \EQM\Core\Factories\InvalidModelException
     */
    private function resolveModel($model)
    {
        if (! isset($this->models[$model])) {
            throw InvalidModelException::notRegistered($model);
        }

        return $this->models[$model];
    }
}

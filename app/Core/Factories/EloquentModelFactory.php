<?php
namespace EQM\Core\Factories;

use EQM\Events\Event;
use EQM\Models\Addresses\Address;
use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Advertising\Advertisements\EloquentRectangle;
use EQM\Models\Advertising\Advertisements\Rectangle;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompany;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Comments\Comment;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Companies\EloquentStable;
use EQM\Models\Companies\Horses\CompanyHorse;
use EQM\Models\Companies\Horses\EloquentCompanyHorse;
use EQM\Models\Companies\Stable;
use EQM\Models\Companies\Users\EloquentFollower;
use EQM\Models\Companies\Users\Follower;
use EQM\Models\Disciplines\Discipline;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Notifications\Notification;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Palmares\Palmares;
use EQM\Models\Pedigrees\EloquentPedigree;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Statuses\CompanyStatus;
use EQM\Models\Statuses\EloquentCompanyStatus;
use EQM\Models\Statuses\EloquentHorseStatus;
use EQM\Models\Statuses\HorseStatus;
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
        Album::class => EloquentAlbum::class,
        Rectangle::class => EloquentRectangle::class,
        AdvertisingCompany::class => EloquentAdvertisingCompany::class,
        AdvertisingContact::class => EloquentAdvertisingContact::class,
        Comment::class => EloquentComment::class,
        CompanyHorse::class => EloquentCompanyHorse::class,
        CompanyStatus::class => EloquentCompanyStatus::class,
        Discipline::class => EloquentDiscipline::class,
        Event::class => EloquentEvent::class,
        Stable::class => EloquentStable::class,
        Follower::class => EloquentFollower::class,
        Horse::class => EloquentHorse::class,
        HorseTeam::class => EloquentHorseTeam::class,
        Palmares::class => EloquentPalmares::class,
        Pedigree::class => EloquentPedigree::class,
        Notification::class => EloquentNotification::class,
        HorseStatus::class => EloquentHorseStatus::class,
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

<?php

use Carbon\Carbon;
use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Advertising\Advertisements\EloquentRectangle;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompany;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Companies\EloquentStable;
use EQM\Models\Companies\Horses\EloquentCompanyHorse;
use EQM\Models\Companies\Users\EloquentFollower;
use EQM\Models\Conversations\EloquentConversation;
use EQM\Models\Conversations\EloquentMessage;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Pedigrees\EloquentPedigree;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\Statuses\EloquentCompanyStatus;
use EQM\Models\Statuses\EloquentHorseStatus;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Wiki\Articles\EloquentArticle;
use EQM\Models\Wiki\Topics\EloquentTopic;
use Faker\Generator;

$factory->define(EloquentUser::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentHorse::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentHorseTeam::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentHorseStatus::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentPalmares::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentEvent::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentPedigree::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentComment::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentDiscipline::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentPicture::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentAlbum::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentAdvertisingContact::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentAdvertisingCompany::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentAddress::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentRectangle::class, function(Generator $faker) {
    return [];
});
$factory->define(EloquentStable::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentFollower::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentCompanyHorse::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentCompanyStatus::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentNotification::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentConversation::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentMessage::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentTopic::class, function (Generator $faker) {
    return [];
});
$factory->define(EloquentArticle::class, function(Generator $faker) {
    return [];
});

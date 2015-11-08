<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Carbon\Carbon;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    return [
        'last_name' => $faker->name,
        'first_name' => $faker->name,
        'email' => $faker->email,
        'language' => 'en',
        'activated' => true,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(EloquentHorse::class, function (Generator $faker) {
    return [
        'name' => 'test horse',
        'life_number' => $faker->randomNumber(),
        'date_of_birth' => Carbon::now(),
        'slug' => 'test-horse',
        'gender' => 1,
        'color' => 1,
        'height' => '1m70',
        'breed' => 1,
    ];
});

$factory->define(EloquentHorseTeam::class, function (Generator $faker) {
    return [
        'type' => 1,
    ];
});

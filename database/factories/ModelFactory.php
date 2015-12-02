<?php

use Carbon\Carbon;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Users\EloquentUser;
use Faker\Generator;

$factory->define(EloquentUser::class, function (Generator $faker) {
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

$factory->define(\EQM\Models\Statuses\EloquentStatus::class, function (Generator $faker) {
    return [
        'body' => $faker->text,
    ];
});

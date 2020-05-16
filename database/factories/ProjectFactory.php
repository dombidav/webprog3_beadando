<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'owner_id' => \App\User::all()->random()->id,
        'name' => $faker->sentence,
        'description' => $faker->randomHtml(),
        'deadline' => $faker->dateTime('2020-12-31 00:00:01')
    ];
});

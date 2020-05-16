<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'project_id' => \App\Project::all()->random()->id,
        'owner_id' => \App\User::all()->random()->id,
        'deadline' => $faker->dateTime('2020-12-31 00:00:01'),
        'title' => $faker->sentence,
        'content' => $faker->randomHtml(),
    ];
});

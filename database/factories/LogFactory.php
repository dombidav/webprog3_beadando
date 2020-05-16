<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'project_id' => \App\Project::all()->random(),
        'user_id' => \App\User::all()->random(),
        'message' => $faker->randomHtml(2)
    ];
});

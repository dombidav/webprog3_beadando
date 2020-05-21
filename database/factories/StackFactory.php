<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stack;
use Faker\Generator as Faker;

$factory->define(Stack::class, function (Faker $faker) {
    return [
        'project_id' => \App\Project::all()->random(),
        'name' => $faker->sentence(2),
        'col' => $faker->numberBetween(0,5),
        'row' => $faker->numberBetween(0,5)
    ];
});

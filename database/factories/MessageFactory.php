<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $sender = App\User::all()->random();
    return [
        'sender_id' => $sender,
        'recipient_id' => App\User::all()->where('id', '<>', $sender->id)->random(),
        'subject' => $faker->sentence,
        'content' => $faker->randomHtml(2),
        'priority' => $faker->randomDigit
    ];
});

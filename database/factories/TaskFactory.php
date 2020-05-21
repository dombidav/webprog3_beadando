<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'stack_id' => \App\Stack::all()->random()->id,
        'user_id' => \App\User::all()->random()->id,
        'deadline' => '2020-12-31 00:00:01',
        'title' => $faker->sentence(2),
        'content' => $faker->boolean(30) ? '<h4>Quis non odit sordidos, vanos, leves, futtiles?</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eam tum adesse, cum dolor omnis absit; Sint modo partes vitae beatae. At enim hic etiam dolore. </p><ul><li>Duo Reges: constructio interrete.</li><li>An eum locum libenter invisit, ubi Demosthenes et Aeschines inter se decertare soliti sunt?</li><li>Illud mihi a te nimium festinanter dictum videtur, sapientis omnis esse semper beatos;</li><li>Nec enim ignoras his istud honestum non summum modo, sed etiam, ut tu vis, solum bonum videri.</li></ul><pre>Sed quid minus probandum quam esse aliquem beatum nec satis beatum? An eum discere ea mavis, quae cum plane perdidiceriti nihilsciat?</pre>' : ''
    ];
});

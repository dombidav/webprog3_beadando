<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'owner_id' => \App\User::all()->random()->id,
        'name' => $faker->sentence,
        'description' => '<h4>Quis non odit sordidos, vanos, leves, futtiles?</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eam tum adesse, cum dolor omnis absit; Sint modo partes vitae beatae. At enim hic etiam dolore. </p><ul><li>Duo Reges: constructio interrete.</li><li>An eum locum libenter invisit, ubi Demosthenes et Aeschines inter se decertare soliti sunt?</li><li>Illud mihi a te nimium festinanter dictum videtur, sapientis omnis esse semper beatos;</li><li>Nec enim ignoras his istud honestum non summum modo, sed etiam, ut tu vis, solum bonum videri.</li></ul><pre>Sed quid minus probandum quam esse aliquem beatum nec satis beatum? An eum discere ea mavis, quae cum plane perdidiceriti nihilsciat?</pre>',
        'deadline' => $faker->dateTime('2020-12-31 00:00:01')
    ];
});

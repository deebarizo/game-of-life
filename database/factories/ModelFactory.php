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

$factory->define(App\Image::class, function($faker) {
    return [
        'filename' => $faker->word,
        'is_daily' => 0
    ];
});

$factory->define(App\BadHabit::class, function($faker) {
    return [
        'name' => ucfirst($faker->word).' '.ucfirst($faker->word).' '.ucfirst($faker->word),
        'description' => null,
        'image_url' => 'files/images/experiment.png',
        'is_success' => 0
    ];
});

$factory->define(App\Task::class, function($faker) {
    return [
        'image_id' => function () {
            return factory('App\Image')->create()->id;
        },
        'name' => ucfirst($faker->word).' '.ucfirst($faker->word).' '.ucfirst($faker->word),
        'is_daily' => 0, 
        'is_complete' => 0,
        'completed_at' => null,
        'is_in_history' => 0,
        'description' => null,
        'link' => null,
        'order' => null
    ];
});
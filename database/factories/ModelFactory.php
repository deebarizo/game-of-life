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

$factory->define(App\Task::class, function($faker) {
    return [
        'name' => $faker->word.' '.$faker->word,
        'is_complete' => 0,
        'completed_at' => null,
        'image_url' => 'cool_image.jpg',
        'is_in_history' => 0,
        'description' => null,
        'link' => null,
        'order' => null
    ];
});
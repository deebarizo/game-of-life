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

$factory->define(App\Models\Option::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'start_time' => 0,
        'end_time' => 24,
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13'
    ];
});
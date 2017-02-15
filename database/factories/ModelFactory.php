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

$factory->define(App\Models\DailyTask::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'name' => $faker->name,
        'description' => $faker->name,
        'link' => 'http://google.com',
        'image_url' => url('/files/images/daily_task_10.png'),
        'order' => 0,
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13',
        'deleted_at' => null
    ];
});

$factory->define(App\Models\DailyTaskInstance::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'daily_task_id' => 1,
        'date' => '2015-03-13',
        'start_time' => 0,
        'end_time' => 24,
        'is_complete' => 0,
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13'
    ];
});

$factory->define(App\Models\BadHabit::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'name' => $faker->name,
        'description' => $faker->name,
        'image_url' => url('/files/images/daily_task_10.png'),
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13',
        'deleted_at' => null
    ];
});

$factory->define(App\Models\BadHabitInstance::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'bad_habit_id' => 1,
        'date' => '2015-03-13',
        'is_success' => 1,
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13'
    ];
});

$factory->define(App\Models\Option::class, function ($faker) {
    
    return [
        
        'id' => 1,
        'start_time' => 0,
        'end_time' => 24,
        'created_at' => '2015-03-13',
        'updated_at' => '2015-03-13'
    ];
});
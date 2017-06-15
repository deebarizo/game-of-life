<?php


/****************************************************************************************
TASKS
****************************************************************************************/

Route::get('/', 'TasksController@daily_tasks');

Route::resource('tasks', 'TasksController');

Route::get('/tasks/{task}/focus', 'TasksController@focus');

Route::post('/tasks/complete', 'TasksController@complete');


/****************************************************************************************
BAD HABITS
****************************************************************************************/

Route::resource('bad_habits', 'BadHabitsController', ['except' => [
    'show', 'edit', 'update', 'destroy'
]]);

Route::get('/bad_habits/{badHabit}', 'BadHabitsController@show');

Route::get('/bad_habits/{badHabit}/edit', 'BadHabitsController@edit');

Route::put('/bad_habits/{badHabit}', 'BadHabitsController@update');

Route::delete('/bad_habits/{badHabit}', 'BadHabitsController@destroy');


/****************************************************************************************
DAILY PROCESS
****************************************************************************************/

Route::post('/run_daily_process', 'DailyProcessController@run_daily_process');
<?php

/****************************************************************************************
TASKS
****************************************************************************************/

Route::resource('tasks', 'TasksController');

Route::get('/tasks/{task}/focus', 'TasksController@focus');

Route::post('/tasks/complete', 'TasksController@complete');
<?php

/****************************************************************************************
TASKS
****************************************************************************************/

Route::resource('tasks', 'TasksController');

Route::post('/tasks/complete', 'TasksController@complete');
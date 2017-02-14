<?php

/****************************************************************************************
HOME AND SITEMAP
****************************************************************************************/

Route::get('/', function() {

	return redirect('/daily_tasks');
});

Route::get('/sitemap', function() {

	$h2Tag = 'Sitemap';

	return view('/sitemap', compact('h2Tag'));
});


/****************************************************************************************
DAILY TASKS
****************************************************************************************/

Route::resource('daily_tasks', 'DailyTasksController');


/****************************************************************************************
OPTIONS
****************************************************************************************/

Route::resource('options', 'OptionsController');
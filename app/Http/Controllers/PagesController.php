<?php

namespace App\Http\Controllers;

use App\Models\DailyTaskInstance;

use App\UseCases\InstanceCreator;

class PagesController extends Controller {

    /**
     * Show home page.
     * @return void
     */
	public function home() {

		$h2Tag = '';

		$instanceCreator = new InstanceCreator;
        $date = new \DateTime();
        $currentDate = $instanceCreator->createInstances('Daily Task', $optionId = 1, $date);

        $dailyTasks['progress'] = [

        	'numCompleteTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->where('is_complete', true)->count(),
        	'numTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->count(),
        ];

        $dailyTasks['progress']['barWidth'] = intval($dailyTasks['progress']['numCompleteTasks'] / $dailyTasks['progress']['numTasks'] * 100);

		return view('pages/home', compact('h2Tag', 'dailyTasks'));
	}
}
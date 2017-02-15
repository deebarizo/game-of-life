<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\DailyTaskInstance;
use App\Models\BadHabitInstance;

use App\UseCases\DateCalculator;
use App\UseCases\InstanceCreator;
use App\UseCases\StreakCalculator;

class PagesController extends Controller {

    /**
     * Show home page.
     * @return void
     */
	public function home() {

		$h2Tag = '';

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $date = new \DateTime();
        $currentDate = $dateCalculator->getCurrentDate($option, $date);

        $instanceCreator = new InstanceCreator;
        $instanceCreator->createInstances('Daily Task', $currentDate, $option);

        $dailyTasks['progress'] = [

        	'numCompleteTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->where('is_complete', true)->count(),
        	'numTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->count(),
        ];

        $dailyTasks['progress']['barWidth'] = intval($dailyTasks['progress']['numCompleteTasks'] / $dailyTasks['progress']['numTasks'] * 100);

		return view('pages/home', compact('h2Tag', 'dailyTasks'));
	}
}
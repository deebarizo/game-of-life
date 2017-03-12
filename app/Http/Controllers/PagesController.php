<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\DailyTaskInstance;
use App\Models\BadHabitInstance;
use App\Models\TaskInstance;

use App\UseCases\DateCalculator;
use App\UseCases\InstanceCreator;
use App\UseCases\StreakCalculator;
use App\UseCases\PercentageCalculator;

class PagesController extends Controller {

    /**
     * Show home page.
     * @return void
     */
	public function home() {

		$h2Tag = '';

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());

        # ddAll($currentDate);


        /****************************************************************************************
        DAILY TASKS
        ****************************************************************************************/

        $instanceCreator = new InstanceCreator;
        $instanceCreator->createInstances('Daily Task', $currentDate, $option);

        $dailyTasks['progress'] = [

        	'numCompleteTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->where('is_complete', true)->count(),
        	'numTasks' => DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->count()
        ];

        $dailyTasks['progress']['barWidth'] = intval($dailyTasks['progress']['numCompleteTasks'] / $dailyTasks['progress']['numTasks'] * 100);


        /****************************************************************************************
        TASKS
        ****************************************************************************************/

        $tasks['progress'] = [

            'numCompleteTasks' => TaskInstance::where('date', $currentDate->format('Y-m-d'))->where('is_complete', 1)->count(),
            'numTasks' => TaskInstance::where('date', $currentDate->format('Y-m-d'))->count()
        ];

        $tasks['progress']['barWidth'] = ($tasks['progress']['numTasks'] > 0 ? intval($tasks['progress']['numCompleteTasks'] / $tasks['progress']['numTasks'] * 100) : 0);


        /****************************************************************************************
        BAD HABITS
        ****************************************************************************************/

        $instanceCreator->createInstances('Bad Habit', $currentDate, $option);

        $streakCalculator = new StreakCalculator;
        $badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);
        $badHabitInstanceGoal = 10;

        # ddAll($badHabitInstanceStreak);

        $badHabits['progress'] = [

            'streak' => $badHabitInstanceStreak,
            'goal' => $badHabitInstanceGoal,
            'barWidth' => intval($badHabitInstanceStreak / $badHabitInstanceGoal * 100)
        ];

        $percentageCalculator = new PercentageCalculator;

        $badHabits['percentage'] = $percentageCalculator->calculateBadHabitPercentage($currentDate);

        # ddAll('stop');

		return view('pages/home', compact('h2Tag', 'dailyTasks', 'tasks', 'badHabits'));
	}
}
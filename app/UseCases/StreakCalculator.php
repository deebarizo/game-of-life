<?php namespace App\UseCases;

use App\Models\BadHabitInstance;

class StreakCalculator {

    /**
     * Create bad habit instance streak.
     * @param  \DateTime $currentDate
	 * @return int $badHabitInstanceStreak
     */

    public function calculateBadHabitInstanceStreak(\DateTime $currentDate) {

    	$yesterdayDate = $currentDate->modify('-1 day');
    	$currentDate->modify('+1 day');

    	if (BadHabitInstance::where('bad_habit_id', 1)->where('date', $yesterdayDate->format('Y-m-d'))->where('is_success', 1)->count() > 0 &&
    		BadHabitInstance::where('bad_habit_id', 1)->where('date', $currentDate->format('Y-m-d'))->where('is_success', 1)->count() > 0) {

    		$streakExists = true;

    		$latestFail = BadHabitInstance::where('bad_habit_id', 1)->where('is_success', 0)->first();

    		if (!$latestFail) {

    			return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDate->format('Y-m-d'))->where('is_success', 1)->count();
    		}

    		return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDate->format('Y-m-d'))->where('date', '>', $latestFail->date)->where('is_success', 1)->count();
    	
    	} else {

    		return 0;
    	}
    }

}

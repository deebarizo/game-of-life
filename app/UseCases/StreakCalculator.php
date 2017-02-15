<?php namespace App\UseCases;

use App\Models\BadHabitInstance;

class StreakCalculator {

    /**
     * Create bad habit instance streak.
     * @param  \DateTime $currentDate
	 * @return int $badHabitInstanceStreak
     */

    public function calculateBadHabitInstanceStreak(\DateTime $currentDate) {

    	$currentDate->modify('-1 day');
    	$yesterdayDate = $currentDate;

    	if (BadHabitInstance::where('bad_habit_id', 1)->where('date', $yesterdayDate)->where('is_success', 1)->count() > 0 &&
    		BadHabitInstance::where('bad_habit_id', 1)->where('date', $currentDate)->where('is_success', 1)->count() > 0) {

    		$streakExists = true;

    		$latestFail = BadHabitInstance::where('bad_habit_id', 1)->where('is_success', 0)->first();

    		if (!$latestFail) {

    			return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDate)->where('is_success', 1)->count();
    		}

    		return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDate)->where('date', '>', $latestFail->date)->where('is_success', 1)->count();
    	
    	} else {

    		return 0;
    	}
    }

}

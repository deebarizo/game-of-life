<?php namespace App\UseCases;

use App\Models\BadHabitInstance;

class StreakCalculator {

    /**
     * Create bad habit instance streak.
     * @param  \DateTime $currentDate
	 * @return int $badHabitInstanceStreak
     */

    public function calculateBadHabitInstanceStreak(\DateTime $currentDate) {

    	$yesterdayDateString = $currentDate->modify('-1 day')->format('Y-m-d');
    	$currentDateString = $currentDate->modify('+1 day')->format('Y-m-d');

        # prf($currentDate);
        # prf($yesterdayDateString);
        # ddAll($currentDateString);

    	if (BadHabitInstance::where('bad_habit_id', 1)->where('date', $yesterdayDateString)->where('is_success', 1)->count() > 0 &&
    		BadHabitInstance::where('bad_habit_id', 1)->where('date', $currentDateString)->where('is_success', 1)->count() > 0) {

    		$streakExists = true;

    		$latestFail = BadHabitInstance::where('bad_habit_id', 1)->where('is_success', 0)->orderBy('date', 'desc')->first();

    		if (!$latestFail) {

    			return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDateString)->where('is_success', 1)->count();
    		}

    		return BadHabitInstance::where('bad_habit_id', 1)->where('date', '<=', $yesterdayDateString)->where('date', '>', $latestFail->date)->where('is_success', 1)->count();
    	
    	} else {

    		return 0;
    	}
    }

}

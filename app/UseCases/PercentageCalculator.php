<?php namespace App\UseCases;

use App\Models\BadHabitInstance;

class PercentageCalculator {

    /**
     * Create bad habit percentage.
     * @param  \DateTime $currentDate
	 * @return float $badHabitPercentage
     */

    public function calculateBadHabitPercentage(\DateTime $currentDate) {

    	$currentDateString = $currentDate->format('Y-m-d');
    	# ddAll($currentDateString);

    	if (BadHabitInstance::where('bad_habit_id', 1)->where('date', $currentDateString)->where('is_success', 1)->count() > 0) {

    		$yesterdayDateString = $currentDate->modify('-1 day')->format('Y-m-d');

    		$numOfSuccesses = BadHabitInstance::where('date', '<=', $yesterdayDateString)->where('is_success', 1)->count();
    		$totalInstances = BadHabitInstance::where('date', '<=', $yesterdayDateString)->count();

    		return numFormat(($numOfSuccesses / $totalInstances) * 100, 2);
    	
    	} else {

    		$numOfSuccesses = BadHabitInstance::where('date', '<=', $currentDateString)->where('is_success', 1)->count();
    		$totalInstances = BadHabitInstance::where('date', '<=', $currentDateString)->count();

    		return numFormat(($numOfSuccesses / $totalInstances) * 100, 2);
    	}
    }

}

<?php namespace App\UseCases;

use App\Models\Option;

class DateCalculator {

    /**
     * Get current date based on options table. Look at columns, start_time and end_time.
     * @param \App\Models\Option
     * @param \DateTime $date
     * @return \DateTime $currentDate
     */

    public function getCurrentDate(Option $option, $date) {

    	if ($option->start_time < 0) { // negative start_time means current date may be tomorrow

    		if ($date->format('H') >= 24 + $option->start_time) {

    			$date->modify('+1 day');

    			return $date;
    		}
    	}

    	return $date;
    }
}


	   
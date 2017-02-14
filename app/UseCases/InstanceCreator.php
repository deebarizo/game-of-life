<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Models\Option;

class InstanceCreator {

    /**
     * Create (if needed) new instances and store to the database.
     * @param  string $type Type of element (Daily Task, Quest, etc.)
     * @param  int $optionId 
	 * @return void
     */

    public function createInstances($type, $optionId) {

    	$currentDate = $this->getCurrentDate($optionId);

    	ddAll($currentDate);
    }

    /**
     * Get current date based on options table. Look at columns, start_time and end_time.
     * @param  int $optionId 
     * @return string (in date format, YYYY-MM-DD)
     */

    private function getCurrentDate($optionId) {

    	$option = Option::find($optionId);

    	$date = new \DateTime();

    	if ($option->start_time < 0) { // negative start_time means current date may be tomorrow

    		if ($date->format('H') >= 24 + $option->start_time) {

    			$date->modify('+1 day');

    			return $date->format('Y-m-d');
    		}
    	}

    	return $date->format('Y-m-d');
    }

}
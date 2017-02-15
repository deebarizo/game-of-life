<?php namespace App\UseCases;

use App\Models\Option;
use App\Models\DailyTask;
use App\Models\DailyTaskInstance;

class InstanceCreator {

    /**
     * Create (if needed) new instances and store to the database.
     * @param  string $type Type of element (Daily Task, Quest, etc.)
     * @param  int $optionId 
	 * @return string $currentDate (in date format, YYYY-MM-DD)
     */

    public function createInstances($type, $optionId, $date) {

    	$option = Option::find($optionId);

    	$currentDate = $this->getCurrentDate($option, $date);

    	switch ($type) {
    		
    		case 'Daily Task':

    			$dailyTaskInstances = DailyTaskInstance::where('date', $currentDate)->get();

    			if (count($dailyTaskInstances) == 0) {

                    $latestDailyTaskInstance = DailyTaskInstance::orderBy('date', 'desc')->first();
                    
                    if (count($latestDailyTaskInstance) == 0) { // database has zero rows

                        $latestDate = $currentDate->modify('-1 day');

                        $missingDays = 1;
                    
                    } else {

                        $latestDate = new \DateTime($latestDailyTaskInstance->date);

                        $difference = $latestDate->diff($currentDate);

                        $missingDays = $difference->d;
                    }

                    $dailyTasks = DailyTask::all();

                    for ($i = 0; $i < $missingDays; $i++) { 
                        
                        $latestDate->modify('+1 day');

                        foreach ($dailyTasks as $dailyTask) {
                            
                            $dailyTaskInstance = new DailyTaskInstance;

                            $dailyTaskInstance->daily_task_id = $dailyTask->id;
                            $dailyTaskInstance->date = $latestDate->format('Y-m-d');
                            $dailyTaskInstance->start_time = $option->start_time;
                            $dailyTaskInstance->end_time = $option->end_time;
                            $dailyTaskInstance->is_complete = false;

                            $dailyTaskInstance->save();
                        }                             
                    }
                } 
    	}

        return $currentDate;
    }

    /**
     * Get current date based on options table. Look at columns, start_time and end_time.
     * @param  \App\Models\Option
     * @return string (in date format, YYYY-MM-DD)
     */

    public function getCurrentDate($option, $date) {

    	if ($option->start_time < 0) { // negative start_time means current date may be tomorrow

    		if ($date->format('H') >= 24 + $option->start_time) {

    			$date->modify('+1 day');

    			return $date;
    		}
    	}

    	return $date;
    }

}
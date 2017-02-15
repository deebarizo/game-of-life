<?php namespace App\UseCases;

use App\Models\Option;
use App\Models\DailyTask;
use App\Models\DailyTaskInstance;
use App\Models\BadHabit;
use App\Models\BadHabitInstance;

class InstanceCreator {

    /**
     * Create (if needed) new instances and store to the database.
     * @param  string $type Type of element (Daily Task or Bad Habit)
     * @param  int $optionId 
	 * @return \DateTime $currentDate
     */

    public function createInstances($type, $optionId, $date) {

    	$option = Option::find($optionId);

    	$currentDate = $this->getCurrentDate($option, $date);

    	switch ($type) {
    		
    		case 'Daily Task':

    			$instances = DailyTaskInstance::where('date', $currentDate)->get();

    			if (count($instances) == 0) {

                    $latestInstance = DailyTaskInstance::orderBy('date', 'desc')->first();
                    
                    list($latestDate, $missingDays) = $this->calculateMissingDays($latestInstance, $currentDate);

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

            case 'Bad Habit':

                $instances = BadHabitInstance::where('date', $currentDate)->get();

                if (count($instances) == 0) {

                    $latestInstance = BadHabitInstance::orderBy('date', 'desc')->first();
                    
                    list($latestDate, $missingDays) = $this->calculateMissingDays($latestInstance, $currentDate);

                    $badHabits = BadHabit::all();

                    for ($i = 0; $i < $missingDays; $i++) { 
                        
                        $latestDate->modify('+1 day');

                        foreach ($badHabits as $badHabit) {

                            $badHabitInstance = new BadHabitInstance;

                            $badHabitInstance->bad_habit_id = $badHabit->id;
                            $badHabitInstance->date = $latestDate->format('Y-m-d');
                            $badHabitInstance->is_success = true;

                            $badHabitInstance->save();
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

    /**
     * Get $missingDays based on latest instance by date and current date.
     * @param \App\Models\DailyTaskInstance or \App\Models\BadHabitInstance
     * @param \DateTime $currentDate
     * @return [\DateTime $latestDate, int $missingDays]
     */

    private function calculateMissingDays($latestInstance, $currentDate) {

        if (count($latestInstance) == 0) { // database has zero rows

            $latestDate = $currentDate->modify('-1 day');

            return [$latestDate, 1];
        }

        $latestDate = new \DateTime($latestInstance->date);

        $difference = $latestDate->diff($currentDate);

        return [$latestDate, $difference->d];
    }

}
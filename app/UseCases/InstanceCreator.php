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
     * @param  \DateTime $currentDate
	 * @return void
     */

    public function createInstances($type, \DateTime $currentDate, Option $option) {

    	switch ($type) {
    		
    		case 'Daily Task':

    			$instances = DailyTaskInstance::where('date', $currentDate->format('Y-m-d'))->get();

    			if (count($instances) == 0) {

                    $latestInstance = DailyTaskInstance::orderBy('date', 'desc')->first();
                    
                    list($latestDate, $missingDays) = $this->calculateMissingDays($latestInstance, $currentDate);

                    $dailyTasks = DailyTask::all();

                    for ($i = 0; $i < $missingDays; $i++) { 
                        
                        $latestDate->modify('+1 day');

                        foreach ($dailyTasks as $dailyTask) {

                            if (DailyTaskInstance::where('daily_task_id', $dailyTask->id)->where('date', $latestDate->format('Y-m-d'))->count() === 0) {

                                $dailyTaskInstance = new DailyTaskInstance;

                                $dailyTaskInstance->daily_task_id = $dailyTask->id;
                                $dailyTaskInstance->date = $latestDate->format('Y-m-d');
                                $dailyTaskInstance->start_time = $option->start_time;
                                $dailyTaskInstance->end_time = $option->end_time;
                                $dailyTaskInstance->is_complete = false;

                                $dailyTaskInstance->save();
                            }
                        }

                        # prf('loop1');                             
                    }
                }

                break; 

            case 'Bad Habit':

                $instances = BadHabitInstance::where('date', $currentDate->format('Y-m-d'))->get();

                if (count($instances) == 0) {

                    $latestInstance = BadHabitInstance::orderBy('date', 'desc')->first();
                    
                    list($latestDate, $missingDays) = $this->calculateMissingDays($latestInstance, $currentDate);

                    $badHabits = BadHabit::all();

                    for ($i = 0; $i < $missingDays; $i++) { 
                        
                        $latestDate->modify('+1 day');

                        foreach ($badHabits as $badHabit) {

                            if (BadHabitInstance::where('bad_habit_id', $badHabit->id)->where('date', $latestDate->format('Y-m-d'))->count() === 0) {

                                $badHabitInstance = new BadHabitInstance;

                                $badHabitInstance->bad_habit_id = $badHabit->id;
                                $badHabitInstance->date = $latestDate->format('Y-m-d');
                                $badHabitInstance->is_success = true;

                                $badHabitInstance->save();
                            }
                        }   

                        # prf('loop2');                          
                    }
                } 

                break;
    	}
    }


    /**
     * Get $missingDays based on latest instance by date and current date.
     * @param \App\Models\DailyTaskInstance or \App\Models\BadHabitInstance
     * @param \DateTime $currentDate
     * @return [\DateTime $latestDate, int $missingDays]
     */

    private function calculateMissingDays($latestInstance, \DateTime $currentDate) {

        if (count($latestInstance) == 0) { // database has zero rows

            $latestDate = $currentDate->modify('-1 day');

            return [$latestDate, 1];
        }

        $latestDate = new \DateTime($latestInstance->date);

        $difference = $latestDate->diff($currentDate);

        return [$latestDate, $difference->d];
    }

}
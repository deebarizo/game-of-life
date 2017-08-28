<?php namespace App\UseCases;

use App\Task;
use App\BadHabit;

class DailyTasksProcessor {

    public function generate_daily_tasks($todayDate) 
    {
        $carbonDate = Task::select('created_at')->orderBy('created_at', 'desc')->pluck('created_at')->first();
        $timeDiff = config('settings.time_diff');
        $todayDate->modify($timeDiff);

        if ($carbonDate) {
            $dateString = $carbonDate->format('Y-m-d');

            $tasks = Task::where('created_at', 'LIKE', $dateString.'%')
                        ->where(function($query) {
                            return $query->where('is_daily', 1)
                                        ->orWHere('is_complete', 0);
                        })
                        ->orderBy('order', 'asc')->get();
        } else {
            $tasks = [];
        }

        $carbonDate = BadHabit::select('created_at')->orderBy('created_at', 'desc')->pluck('created_at')->first();

        if ($carbonDate) {
            $dateString = $carbonDate->format('Y-m-d');

            $badHabits = BadHabit::where('created_at', 'LIKE', $dateString.'%')
                            ->orderBy('id', 'asc')
                            ->get();
        } else {
            $badHabits = [];
        }

        foreach ($tasks as $task) {
        	if ($task->is_complete == 0 && $task->is_daily == 0) {
                $newTask = new Task;

                $newTask = $task->replicate();
        		$newTask->created_at = $todayDate->format('Y-m-d H:i:s');

                $newTask->completed_at = null;

        		$newTask->save();

        		continue;
        	}

        	if ($task->is_daily = 1) {
                $newTask = new Task;

        		$newTask = $task->replicate();
        		$newTask->created_at = $todayDate->format('Y-m-d H:i:s'); 

                $newTask->is_complete = 0;

                $newTask->completed_at = null;

        		$newTask->save();
        	}
        }

        foreach ($badHabits as $badHabit) {
            $newBadHabit = new BadHabit;

            $newBadHabit = $badHabit->replicate();
            $newBadHabit->created_at = $todayDate->format('Y-m-d H:i:s'); 
            $newBadHabit->is_success = 1;
            $newBadHabit->save();
        }

        return $todayDate->format('Y-m-d');
    }
}
<?php namespace App\UseCases;

use App\Task;
use App\BadHabit;

class DailyTasksProcessor {

    public function generate_daily_tasks($todayDate) 
    {
        $carbonDate = Task::select('created_at')->orderBy('created_at', 'desc')->pluck('created_at')->first();
        $todayDate->modify('-6 hours');

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

        $date = clone $todayDate;

        # ddAll($tasks);

        foreach ($tasks as $task) {
        	if ($task->is_complete == 0 && $task->is_daily == 0) {
        		$task->created_at = $date->format('Y-m-d H:i:s');

                $task->completed_at = null;

        		$task->save();
        		continue;
        	}

        	if ($task->is_daily = 1) {
        		$newTask = $task->replicate();
        		$newTask->created_at = $date->format('Y-m-d H:i:s'); 

                $newTask->is_complete = 0;

                $task->completed_at = null;

        		$newTask->save();
        	}
        }

        foreach ($badHabits as $badHabit) {
            $newBadHabit = $badHabit->replicate();
            $newBadHabit->created_at = $date->format('Y-m-d H:i:s'); 
            $newBadHabit->is_success = 1;
            $newBadHabit->save();
        }
    }
}
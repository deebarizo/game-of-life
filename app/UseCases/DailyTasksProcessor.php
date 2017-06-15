<?php namespace App\UseCases;

use App\Task;

class DailyTasksProcessor {

    public function generate_daily_tasks($todayDate) 
    {
        $date = clone $todayDate;
        $date->modify('-24 hours');
        $dateString = $date->format('Y-m-d');

        $tasks = Task::where('updated_at', 'LIKE', $dateString.'%')
        			->where(function($query) {
        				return $query->where('is_daily', 1)
	       							->orWHere('is_complete', 0);
        			})
        			->orderBy('order', 'asc')->get();

        $date->modify('+24 hours');

        foreach ($tasks as $task) {
        	if ($task->is_complete == 0 && $task->is_daily == 0) {
        		$task->updated_at = $date->format('Y-m-d H:i:s');
        		$task->save();
        		break;
        	}

        	if ($task->is_daily = 1) {
        		$newTask = $task->replicate();
        		$newTask->updated_at = $date->format('Y-m-d H:i:s'); 
                $newTask->is_complete = 0;
        		$newTask->save();
        	}
        }
    }
}
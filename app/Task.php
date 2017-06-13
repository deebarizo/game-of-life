<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Task;

use DB;

class Task extends Model
{
    public function path()
    {
    	return '/tasks/'.$this->id;
    }

    public static function groupByDate($numOfDays, $todayDate)
    {
        $startDate = clone $todayDate;
    	$startDate->modify('-'.$numOfDays.' days');

    	$diff = $startDate->diff($todayDate);

		$tasks = [];

    	for ($i = 0; $i < $diff->days; $i++) { 

    		$date = clone $todayDate;
    		$date->modify('-'.$i.' days');
    		$dateString = $date->format('Y-m-d');

    		$tasksByDate = Task::where('created_at', 'LIKE', $dateString.'%')->get();
    		
    		$tasks[$dateString] = $tasksByDate;
    	}

    	return $tasks;
    }
}

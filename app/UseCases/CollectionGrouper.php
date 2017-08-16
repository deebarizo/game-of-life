<?php namespace App\UseCases;

use App\Task;
use App\BadHabit;

class CollectionGrouper {

    public function group_by_date($numOfDays, $todayDate, $model) 
    {
        $startDate = clone $todayDate;
        $startDate->modify('-'.$numOfDays.' days');

        $diff = $startDate->diff($todayDate);

        $models = [];

        for ($i = 0; $i < $diff->days; $i++) { 

            $date = clone $todayDate;
            $date->modify('-'.$i.' days');
            $dateString = $date->format('Y-m-d');

            switch ($model) {
                case 'Task':
                    $modelsByDate = Task::where('updated_at', 'LIKE', $dateString.'%')->where('is_in_history', true)->orderBy('order', 'asc')->get();
                    break;
                
                case 'BadHabit':
                    $modelsByDate = BadHabit::where('created_at', 'LIKE', $dateString.'%')->get();
                    break;
            }

            $models[$dateString] = $modelsByDate;
        }

        return $models;
    }
}


	   
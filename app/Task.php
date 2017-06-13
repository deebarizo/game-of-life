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

    public function description_html()
    {
        return ($this->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$this->description.'</div>');
    }

    public function link_html()
    {
        return ($this->link == '' ? '' : '<a target="_blank" href="'.$this->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
    }

    public function is_in_history_html()
    {
        return ($this->is_in_history ===  1 ? '<img src="'.url('/files/icons/star.png').'">' : '');
    }

    public function is_complete_html()
    {
        return ($this->is_complete ===  1 ? 'text-decoration: line-through' : '');
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

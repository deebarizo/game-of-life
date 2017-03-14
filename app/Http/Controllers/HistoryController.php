<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\DailyTaskInstance;
use App\Models\TaskInstance;
use App\Models\BadHabit;
use App\Models\BadHabitInstance;

use App\Models\Option;

use App\UseCases\DateCalculator;

use DB;

class HistoryController extends Controller {

     /**
     * Show recent history.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

    	$h2Tag = 'History';

    	$firstDate = new \DateTime('2017-03-11');

    	$option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());

    	$startDate = clone $currentDate;
    	$startDate->modify('-4 days');

    	$startDate = ($startDate > $firstDate ? $startDate : $firstDate);

    	$diff = $startDate->diff($currentDate);

    	# prf($firstDate);
    	# prf($startDate);
    	# prf($currentDate);

    	# prf($diff);

    	$instances = [];

    	for ($i = 0; $i < $diff->days + 1; $i++) { 

    		$date = clone $currentDate;
    		$date->modify('-'.$i.' days');
    		$dateString = $date->format('Y-m-d');
    		
	        $dailyTaskInstances = DailyTask::select(DB::raw('daily_task_instances.id as id,
				                                                daily_tasks.name,
				                                                daily_tasks.description,
				                                                daily_tasks.link,
				                                                daily_tasks.image_url,
				                                                daily_tasks.is_in_history,
				                                                daily_task_instances.is_complete,
				                                                daily_task_instances.date,
				                                                daily_task_instances.completed_at,
				                                                unix_timestamp(daily_task_instances.completed_at) as unix_timestamp'))
				                                    ->join('daily_task_instances', function($join) {
				      
				                                        $join->on('daily_task_instances.daily_task_id', '=', 'daily_tasks.id');
				                                    })
				                                    ->where('daily_tasks.is_in_history', 1)
				                                    ->where('daily_task_instances.is_complete', 1)
				                                    ->where('date', $dateString)
				                                    ->orderBy('date', 'desc')
				                                    ->orderBy('completed_at', 'asc')
				                                    ->get()
				                                    ->toArray();

			$taskInstances = TaskInstance::select(DB::raw('id,
															name,
															description,
															link,
															image_url,
															is_complete,
															date,
															completed_at,
															unix_timestamp(completed_at) as unix_timestamp'))
				                                    ->where('is_in_history', 1)
				                                    ->where('is_complete', 1)
				                                    ->where('date', $dateString)
				                                    ->orderBy('date', 'desc')
				                                    ->orderBy('completed_at', 'asc')
				                                    ->get()
				                                    ->toArray();

			$mergedDailyInstances = array_merge($dailyTaskInstances, $taskInstances);

			# prf($mergedDailyInstances);

			if (empty($mergedDailyInstances)) {

				$instances[$dateString] = [];

				continue;
			}

			$unixTimestamps = [];

			// http://php.net/manual/en/function.array-multisort.php

			foreach ($mergedDailyInstances as $key => $row) {

			    $unixTimestamps[$key] = $row['unix_timestamp'];
			}

			# prf($unixTimestamps);

			array_multisort($unixTimestamps, SORT_ASC, $mergedDailyInstances);

    		$instances[$dateString] = $mergedDailyInstances;
    	}

    	# ddAll($instances);

		return view('history/index', compact('h2Tag', 'instances'));
    }

}
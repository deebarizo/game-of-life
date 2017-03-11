<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DailyTask;
use App\Models\DailyTaskInstance;
use App\Models\TaskInstance;

use DB;

class FocusController extends Controller
{

     /**
     * Show focus mode page.
     *
     * @param  string  $instanceType
     * @param  int $id (id of instance type)
     * @return \Illuminate\Http\Response
     */
    public function focus($instanceType, $id)
    {
    	switch ($instanceType) {
        	
        	case 'daily_task':
        		
                $instance = DailyTask::select(DB::raw('daily_tasks.name,
                                                        daily_tasks.description,
                                                        daily_tasks.link,
                                                        daily_tasks.image_url,
                                                        daily_task_instances.is_complete'))
                                            ->join('daily_task_instances', function($join) {
              
                                                $join->on('daily_task_instances.daily_task_id', '=', 'daily_tasks.id');
                                            })
                                            ->where('daily_task_instances.id', $id)
                                            ->first();

        		break;

            case 'task':

                $instance = TaskInstance::find($id);

                break;
        }

        $h2Tag = $instance->name;

        # ddAll($instance);

		return view('focus/index', compact('h2Tag', 'instance'));
    }

}
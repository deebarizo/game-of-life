<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\UseCases\DateCalculator;
use App\UseCases\InstanceCreator;
use App\UseCases\FileUploader;

use App\Models\Option;
use App\Models\DailyTask;
use App\Models\DailyTaskInstance;

use DB;

class DailyTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $h2Tag = 'Daily Tasks'; 

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $date = new \DateTime();
        $currentDate = $dateCalculator->getCurrentDate($option, $date);

        $instanceCreator = new InstanceCreator;
        $instanceCreator->createInstances('Daily Task', $currentDate, $option);

        $dailyTasks = DailyTask::select(DB::raw('daily_tasks.id, 
                                                    daily_tasks.name,
                                                    daily_tasks.description,
                                                    daily_tasks.link,
                                                    daily_tasks.image_url,
                                                    daily_tasks.order,
                                                    daily_task_instances.id as daily_task_instance_id, 
                                                    daily_task_instances.date,
                                                    daily_task_instances.is_complete'))
                                    ->join('daily_task_instances', function($join) {
      
                                        $join->on('daily_task_instances.daily_task_id', '=', 'daily_tasks.id');
                                    })
                                    ->where('date', $currentDate->format('Y-m-d'))
                                    ->get();

        # ddAll($dailyTasks);

        return view('daily_tasks/index', compact('h2Tag', 'dailyTasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h2Tag = 'Create Daily Task';

        return view('daily_tasks/create', compact('h2Tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dailyTask = new DailyTask;

        $dailyTask->name = trim($request->input('name'));
        $dailyTask->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
        $dailyTask->link = (trim($request->input('link')) == '' ? null : trim($request->input('link')));
 
        $dailyTask->save();

        $fileUploader = new FileUploader;

        $imageUrl = $fileUploader->uploadImageFile($request, 'daily_task', $dailyTask->id);

        $dailyTask->image_url = $imageUrl;

        $dailyTask->save();

        return redirect()->route('daily_tasks.index')->with('message', 'Success!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // This will be for stats once I get enough data
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $h2Tag = 'Edit Daily Task';

        $dailyTask = DailyTask::find($id);

        return view('daily_tasks/edit', compact('h2Tag', 'dailyTask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dailyTask = DailyTask::find($id);

        $dailyTask->name = trim($request->input('name'));
        $dailyTask->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
        $dailyTask->link = (trim($request->input('link')) == '' ? null : trim($request->input('link')));
 
        $dailyTask->save();

        return redirect()->route('daily_tasks.index')->with('message', 'Success!'); 
    }

    /**
     * Soft delete the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dailyTask = DailyTask::find($id);

        $dailyTask->delete();
        
        return redirect()->route('daily_tasks.index')->with('message', 'Success!'); 
    }
}

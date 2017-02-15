<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\UseCases\InstanceCreator;
use App\UseCases\FileUploader;

use App\Models\BadHabit;

use DB;

class BadHabitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $h2Tag = 'Bad Habits'; 

        $instanceCreator = new InstanceCreator;
        $date = new \DateTime();
        $currentDate = $instanceCreator->createInstances('Bad Habit', $optionId = 1, $date);
        dd('die');
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

        ddAll($dailyTasks);

        return view('daily_tasks/index', compact('h2Tag', 'dailyTasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h2Tag = 'Create Bad Habit';

        return view('bad_habits/create', compact('h2Tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $badHabit = new BadHabit;

        $badHabit->name = trim($request->input('name'));
        $badHabit->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
 
        $badHabit->save();

        $fileUploader = new FileUploader;

        $imageUrl = $fileUploader->uploadImageFile($request, 'bad_habit', $badHabit->id);

        $badHabit->image_url = $imageUrl;

        $badHabit->save();

        return redirect()->route('bad_habits.index')->with('message', 'Success!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\UseCases\DateCalculator;
use App\UseCases\FileUploader;

use App\Models\Option;
use App\Models\TaskInstance;

use DB;

class TaskInstancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $h2Tag = 'Tasks'; 

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());

        $tasks = TaskInstance::select('*')->where('date', $currentDate->format('Y-m-d'))->get();

        # ddAll($tasks);

        return view('tasks/index', compact('h2Tag', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h2Tag = 'Create Task';

        return view('tasks/create', compact('h2Tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            
            'name' => 'required',
            'image' => 'required'
        ]);

        $taskInstance = new TaskInstance;

        $taskInstance->name = trim($request->input('name'));
        $taskInstance->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
        $taskInstance->link = (trim($request->input('link')) == '' ? null : trim($request->input('link')));

        $taskInstance->save();
 
        $fileUploader = new FileUploader;

        $imageUrl = $fileUploader->uploadImageFile($request, 'task', $taskInstance->id);

        $taskInstance->image_url = $imageUrl;

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());
        $taskInstance->date = $currentDate->format('Y-m-d');

        $taskInstance->start_time = $option->start_time;
        $taskInstance->end_time = $option->end_time;
        $taskInstance->is_complete = 0;
        $taskInstance->completed_at = null;

        $taskInstance->save();

        return redirect()->route('tasks.index')->with('message', 'Success!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not applicable
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $h2Tag = 'Edit Task';

        $task = TaskInstance::find($id);

        return view('tasks/edit', compact('h2Tag', 'task'));
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
        $this->validate($request, [
            
            'name' => 'required'
        ]);

        $taskInstance = TaskInstance::find($id);

        $taskInstance->name = trim($request->input('name'));
        $taskInstance->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
        $taskInstance->link = (trim($request->input('link')) == '' ? null : trim($request->input('link')));

        $taskInstance->save();

        return redirect()->route('tasks.index')->with('message', 'Success!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = TaskInstance::find($id);

        unlink($task->image_url);

        $task->delete();
        
        return redirect()->route('tasks.index')->with('message', 'Success!'); 
    }
}

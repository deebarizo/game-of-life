<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

use App\UseCases\FileUploader;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h2Tag = 'Create Task';

        $task = new Task;
        
        $task->is_in_history = 1; // for view

        return view('tasks/create', compact('h2Tag', 'task'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileUploader = new FileUploader;
        $imageUrl = $fileUploader->uploadImageFile($request);

        $task = new Task;

        $task->name = request('name');
        $task->is_complete = 0; // database defaults to this value
        $task->completed_at = null; // database defaults to this value
        $task->image_url = $imageUrl;
        $task->is_in_history = request('is_in_history');
        $task->description = request('description');
        $task->link = request('link');
        $task->order = null; // database defaults to this value

        $task->save();

        return redirect('/tasks');
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
    public function edit(Task $task)
    {
        $h2Tag = 'Edit Task';

        return view('tasks/edit', compact('h2Tag', 'task'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $fileUploader = new FileUploader;
        $imageUrl = $fileUploader->uploadImageFile($request, $task);

        $task->name = request('name');
        $task->image_url = $imageUrl;
        $task->is_in_history = request('is_in_history');
        $task->description = request('description');
        $task->link = request('link');

        $task->save();

        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks');
    }
    
    
    /****************************************************************************************
    DAILY TASKS (HOME)
    ****************************************************************************************/
    
    public function daily_tasks()
    {
        $h2Tag = 'Daily Tasks'; 

        $tasks = Task::all();
    
        return view('tasks/daily_tasks', compact('h2Tag', 'tasks'));
    }
    

    /****************************************************************************************
    FOCUS MODE
    ****************************************************************************************/

    public function focus(Task $task)
    {
        $h2Tag = 'Focus Mode - '.$task->name;

        return view('tasks/focus', compact('h2Tag', 'task'));
    }


    /****************************************************************************************
    AJAX
    ****************************************************************************************/

    /**
     * Mark task instance complete or not complete. Uses AJAX.
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function complete(Request $request) {

        $taskId = $request->input('taskId');
        $isComplete = ($request->input('isComplete') == 'true' ? 1 : 0);

        $task = Task::find($taskId);

        $task->is_complete = $isComplete;

        if ($isComplete) {
            $date = new \DateTime();
            $task->completed_at = $date->format("Y-m-d H:i:s");
        } else {
            $task->completed_at = null;
        }

        $task->save();
    }
}

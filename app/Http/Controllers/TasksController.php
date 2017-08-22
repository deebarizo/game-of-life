<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\Image;

use App\UseCases\ImageProcessor;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $h2Tag = 'Tasks'; 

        $todayDate = new \DateTime();

        $tasksGroupedByDate = Task::groupByDate(5, $todayDate);
    
        return view('tasks/index', compact('h2Tag', 'tasksGroupedByDate'));
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

        $task->is_daily = 0; // for view        
        $task->is_in_history = 1; // for view

        $image = Image::where('filename', 'default.png')->first(); // for sqlite
        $task->image_id = $image->id; // for view

        $imageProcessor = new ImageProcessor;
        $images = $imageProcessor->get_without_daily();

        return view('tasks/create', compact('h2Tag', 'task', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task;
        $task->is_complete = 0;

        $this->process_form_submission($task, $request);

        return redirect('/');
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

        $imageProcessor = new ImageProcessor;
        $images = $imageProcessor->get_without_daily();

        return view('tasks/edit', compact('h2Tag', 'task', 'images'));
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
        $this->process_form_submission($task, $request);

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

        return redirect('/');
    }


    /****************************************************************************************
    FORM HELPER
    ****************************************************************************************/

    private function process_form_submission($task, $request)
    {
        $order = trim($request->input('order'));

        $task->name = request('name');
        $task->is_daily = request('is_daily');
        $task->image_id = request('image_id');
        $task->is_in_history = request('is_in_history');
        $task->description = request('description');
        $task->link = request('link');
        $task->order = ($order == '' || $order == null ? 0 : $order);

        $isComplete = $request->input('is_complete');

        if ($isComplete) {
            $date = new \DateTime();
            $task->completed_at = $date->format("Y-m-d H:i:s");
        } else {
            $task->completed_at = null;
        }

        $task->is_complete = $isComplete;

        $task->save();
    }
    
    
    /****************************************************************************************
    DAILY TASKS (HOME)
    ****************************************************************************************/
    
    public function daily_tasks()
    {
        $h2Tag = 'Daily Tasks'; 

        $todayDate = new \DateTime;
        $todayDate->modify('-6 hours');

        $dateString = $todayDate->format('Y-m-d');

        $tasks = Task::where('created_at', 'LIKE', $dateString.'%')->orderBy('order', 'asc')->get();
    
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

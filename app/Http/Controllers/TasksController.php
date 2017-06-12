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
        $h2Tag = 'Tasks'; 

        $tasks = Task::all();
    
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
        $fileUploader = new FileUploader;
        $imageUrl = $fileUploader->uploadImageFile($request);

        $task = new Task;

        $task->name = request('name');
        $task->is_complete = 0; // database defaults to this value
        $task->completed_at = null; // database defaults to this value
        $task->image_url = $imageUrl;
        $task->is_in_history = request('is_in_history');
        $task->description = ($request->input('description') == '' ? null : $request->input('description'));
        $task->link = ($request->input('link') == '' ? null : $request->input('link'));
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

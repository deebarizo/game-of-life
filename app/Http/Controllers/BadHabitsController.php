<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BadHabit;

use App\UseCases\FileUploader;

class BadHabitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $h2Tag = 'Create Bad Habit';

        $badHabit = new BadHabit;

        $badHabit->is_success = 0; // for view
        
        return view('bad_habits/create', compact('h2Tag', 'badHabit'));
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
        $imageUrl = $fileUploader->uploadImageFile($request, $badHabit = null);

        $badHabit = new BadHabit;

        $this->process_form_submission($badHabit, $imageUrl, $request);

        return redirect('/bad_habits');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function show(BadHabit $badHabit)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function edit(BadHabit $badHabit)
    {
        $h2Tag = 'Edit Bad Habit';

        return view('bad_habits/edit', compact('h2Tag', 'badHabit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BadHabit $badHabit)
    {
        $fileUploader = new FileUploader;
        $imageUrl = $fileUploader->uploadImageFile($request, $badHabit);

        $this->process_form_submission($badHabit, $imageUrl, $request);

        return redirect('/bad_habits');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function destroy(BadHabit $badHabit)
    {
        //
    }


    /****************************************************************************************
    FORM HELPER
    ****************************************************************************************/

    private function process_form_submission($badHabit, $imageUrl, $request)
    {
        $badHabit->name = request('name');
        $badHabit->description = request('description');
        $badHabit->image_url = $imageUrl;
        $badHabit->is_success = request('is_success');

        $badHabit->save();
    }
}

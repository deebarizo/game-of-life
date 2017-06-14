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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function show(BadHabit $badHabit)
    {
        ddAll($badHabit);

        return 'Bad Habit '.$badHabit->id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BadHabit  $badHabit
     * @return \Illuminate\Http\Response
     */
    public function edit(BadHabit $badHabit)
    {

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

        return redirect('/');
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

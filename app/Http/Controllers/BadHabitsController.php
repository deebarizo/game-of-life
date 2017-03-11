<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\UseCases\DateCalculator;
use App\UseCases\InstanceCreator;
use App\UseCases\FileUploader;

use App\Models\Option;
use App\Models\BadHabit;
use App\Models\BadHabitInstance;

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

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());

        $instanceCreator = new InstanceCreator;
        $instanceCreator->createInstances('Bad Habit', $currentDate, $option);

        $badHabits = BadHabit::select(DB::raw('bad_habits.id, 
                                                    bad_habits.name,
                                                    bad_habits.description,
                                                    bad_habits.image_url,
                                                    bad_habit_instances.id as bad_habit_instance_id, 
                                                    bad_habit_instances.date,
                                                    bad_habit_instances.is_success'))
                                    ->join('bad_habit_instances', function($join) {
      
                                        $join->on('bad_habit_instances.bad_habit_id', '=', 'bad_habits.id');
                                    })
                                    ->where('date', $currentDate->format('Y-m-d'))
                                    ->get();

        return view('bad_habits/index', compact('h2Tag', 'badHabits'));
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
        $this->validate($request, [
            
            'name' => 'required|unique:bad_habits',
            'image' => 'required'
        ]);        

        $badHabit = new BadHabit;

        $badHabit->name = trim($request->input('name'));
        $badHabit->description = (trim($request->input('description')) == '' ? null : trim($request->input('description')));
 
        $badHabit->save();

        $fileUploader = new FileUploader;

        $imageUrl = $fileUploader->uploadImageFile($request, 'bad_habit', $badHabit->id);

        $badHabit->image_url = $imageUrl;

        $badHabit->save();


        /****************************************************************************************
        STORE BAD HABIT INSTANCE
        ****************************************************************************************/

        $badHabitInstance = new BadHabitInstance;

        $badHabitInstance->bad_habit_id = $badHabit->id;

        $option = Option::find(1);

        $dateCalculator = new DateCalculator;
        $currentDate = $dateCalculator->getCurrentDate($option, $date = new \DateTime());
        $badHabitInstance->date = $currentDate->format('Y-m-d');

        $badHabitInstance->is_success = 1;

        $badHabitInstance->save();

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
        $h2Tag = 'Edit Bad Habit';

        $badHabit = BadHabit::find($id);

        return view('bad_habits/edit', compact('h2Tag', 'badHabit'));
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
        $badHabit = BadHabit::find($id);

        $badHabit->name = trim($request->input('name'));
 
        $badHabit->save();

        return redirect()->route('bad_habits.index')->with('message', 'Success!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $badHabit = BadHabit::find($id);

        $badHabit->delete();
        
        return redirect()->route('bad_habits.index')->with('message', 'Success!'); 
    }
}

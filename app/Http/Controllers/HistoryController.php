<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\DailyTaskInstance;
use App\Models\TaskInstance;
use App\Models\BadHabit;
use App\Models\BadHabitInstance;

class HistoryController extends Controller {

     /**
     * Show recent history.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

    	ddAll('good');

		return view('history/index', compact('h2Tag'));
    }

}
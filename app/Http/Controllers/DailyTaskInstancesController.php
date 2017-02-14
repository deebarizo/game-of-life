<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DailyTaskInstance;

use DB;

class DailyTaskInstancesController extends Controller {

    /**
     * Mark daily task instance complete or not complete. Uses AJAX.
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
	public function complete(Request $request) {

		$id = $request->input('dailyTaskInstanceId');
		$isComplete = ($request->input('isComplete') == 'true' ? 1 : 0);

		$dailyTaskInstance = DailyTaskInstance::find($id);

		$dailyTaskInstance->is_complete = $isComplete;

		$dailyTaskInstance->save();
	}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BadHabitInstance;

use DB;

class BadHabitInstancesController extends Controller {

    /**
     * Mark bad habit instance success or not success. Uses AJAX.
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
	public function fail(Request $request) {

		$id = $request->input('badHabitInstanceId');
		$isSuccess = ($request->input('isSuccess') == 'true' ? 1 : 0);

		$badHabitInstance = BadHabitInstance::find($id);

		$badHabitInstance->is_success = $isSuccess;

		$badHabitInstance->save();
	}
}
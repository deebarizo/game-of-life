<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTaskInstance extends Model {
    
    public function daily_task() {

    	return $this->belongsTo(DailyTask::class);
    }
}
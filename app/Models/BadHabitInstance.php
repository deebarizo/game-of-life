<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadHabitInstance extends Model {
    
    public function bad_habit() {

    	return $this->belongsTo(BadHabit::class);
    }
}
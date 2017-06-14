<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadHabit extends Model
{
    public function path()
    {
    	return '/bad_habits/'.$this->id;
    }
}

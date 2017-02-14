<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadHabit extends Model {

	use SoftDeletes; // https://laravel.com/docs/5.4/eloquent#soft-deleting

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

/*
    public function daily_task_instances() {

    	return $this->hasMany(DailyTaskInstance::class);
    } */
}
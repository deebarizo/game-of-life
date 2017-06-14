<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\UseCases\CollectionGrouper;

class BadHabit extends Model
{
    public function path()
    {
    	return '/bad_habits/'.$this->id;
    }

    public static function groupByDate($numOfDays, $todayDate)
    {
        $collectionGrouper = new CollectionGrouper;

        return $collectionGrouper->group_by_date($numOfDays, $todayDate, 'BadHabit');
    }
}

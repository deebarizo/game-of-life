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

    public function is_success_html()
    {
        return ($this->is_success ===  1 ? 'text-decoration: line-through' : '');
    }

    public static function groupByDate($numOfDays, $todayDate)
    {
        $collectionGrouper = new CollectionGrouper;

        return $collectionGrouper->group_by_date($numOfDays, $todayDate, 'BadHabit');
    }
}

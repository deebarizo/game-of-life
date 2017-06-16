<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\UseCases\CollectionGrouper;

class Task extends Model
{
    public function path()
    {
    	return '/tasks/'.$this->id;
    }

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    public function description_html()
    {
        return ($this->description == '' ? '' : '<a class="description" href="#"><img src="'.url('/files/icons/text-lines.png').'"></a><div style="display: none" class="tool-tip-description">'.$this->description.'</div>');
    }

    public function link_html()
    {
        return ($this->link == '' ? '' : '<a target="_blank" href="'.$this->link.'"><img src="'.url('/files/icons/link.png').'"></a>');
    }

    public function is_in_history_html()
    {
        return ($this->is_in_history ===  1 ? '<img src="'.url('/files/icons/star.png').'">' : '');
    }

    public function is_daily_html()
    {
        return ($this->is_daily ===  1 ? '<img src="'.url('/files/icons/daily.png').'">' : '');
    }

    public function is_complete_html()
    {
        return ($this->is_complete ===  1 ? 'text-decoration: line-through' : '');
    }

    public static function groupByDate($numOfDays, $todayDate)
    {
        $collectionGrouper = new CollectionGrouper;

        return $collectionGrouper->group_by_date($numOfDays, $todayDate, 'Task');
    }
}

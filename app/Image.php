<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function task()
    {
        return $this->hasMany('App\Task');
    }
}

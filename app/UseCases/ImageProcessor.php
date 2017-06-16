<?php namespace App\UseCases;

use App\Image;

class ImageProcessor {

    public function get_without_daily() 
    {
        return Image::where('is_daily', 0)->orderBy('filename', 'asc')->get();
    }
}


	   
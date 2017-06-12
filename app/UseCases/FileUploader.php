<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

class FileUploader {


    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request Needed to get image using the Input facade
     * @param string $method store or update
     * @return string Returns file directory + file name
     */

    public function uploadImageFile($request, $task = null) {

        $file = Input::file('image');

        $fileDirectory = 'files/images/';

        if ($file != null) {
            $fileName = $file->getClientOriginalName();

            Input::file('image')->move($fileDirectory, $fileName);  

            return $fileDirectory.$fileName;   
        }

        if ($task == null) {
            return $fileDirectory.'experiment.png';
        } else {
            return $task->image_url;
        }
    }

}
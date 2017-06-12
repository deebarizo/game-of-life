<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

class FileUploader {


    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request Needed to get image using the Input facade
     * @return string Returns file directory + file name
     */

    public function uploadImageFile($request) {

        $file = Input::file('image');

        $fileDirectory = 'files/images/';

        if ($file != null) {

            $fileName = $file->getClientOriginalName();

            Input::file('image')->move($fileDirectory, $fileName);  

            return $fileDirectory.$fileName;   
        }

        return $fileDirectory.'experiment.png';
    }

}
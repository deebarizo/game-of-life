<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

class FileUploader {

    public function uploadImageFile($request, $type, $id) {

    	$fileDirectory = 'files/images/';

        $fileName = $type.'.jpg';

       	Input::file('image')->move($fileDirectory, $fileName);    

        return $fileDirectory . $fileName;   
    }

}
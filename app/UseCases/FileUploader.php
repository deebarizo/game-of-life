<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

class FileUploader {


    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request Needed to get image
     * @param  string $type Type of element (daily task, quest, etc.)
	 * @param  int $id Id of elemt (daily task, quest, etc.)
     * @return string Returns file directory + file name
     */

    public function uploadImageFile($request, $type, $id) {

        $file = Input::file('image');

        $fileName = $file->getClientOriginalName();

        $fileExtension = preg_replace("/(.+)(\.\w\w\w$)/", "$2", $fileName); // $example = '.png';

    	$fileDirectory = 'files/images/';

        $fileName = $type.'_'.$id.$fileExtension;

       	Input::file('image')->move($fileDirectory, $fileName);    

        return $fileDirectory . $fileName;   
    }

}
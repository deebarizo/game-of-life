<?php namespace App\UseCases;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

class FileUploader {


    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request Needed to get image using the Input facade
     * @param  string $type Type of element (daily_task, quest, etc.) that is also appended to file name
	 * @param  int $id Id of elemt (daily task, quest, etc.)
     * @return string Returns file directory + file name
     */

    public function uploadImageFile($request, $type, $id) {

        $file = Input::file('image');

        $fileDirectory = 'files/images/';

        if ($file != null) {

            $fileName = $file->getClientOriginalName();

            $fileExtension = preg_replace("/(.+)(\.\w\w\w$)/", "$2", $fileName); // $example = '.png';

            

            $fileName = $type.'_'.$id.$fileExtension;

            Input::file('image')->move($fileDirectory, $fileName);  

            return $fileDirectory . $fileName;   
        }

        return $fileDirectory.'experiment.png';
    }

}
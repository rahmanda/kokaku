<?php namespace App\Http\Controllers;

use App\Models\Doc;
use Request;
use Validator;
use App\Kokaku\Rss;
use Laravel\Lumen\Routing\Controller as BaseController;

class UploadController extends BaseController {

  public $errors = array();

  /**
   * Upload document, restrict for pdf type only
   * 
   * @return Response
   */
  public function upload() {

    $files = Request::file('files');
    $date = Request::input('date');
    list($year, $month, $day) = explode('-', $date);

    // $destinationPath = storage_path().'/app/docs/'.$year.'/'.$month.'/'; // need to be configurable later
    $destinationPath = storage_path().'/app/docs/'; 

    foreach($files as $file) {
      if($this->isValidPdf($file)) {
        $filename = str_random(40).'.pdf';
        $file->move($destinationPath, $filename);
      } else {
        array_push($this->errors, 'File '.$file->getClientOriginalName().' is not valid pdf.');
      }
    }

    if(count($this->errors)) {
      return response()->json($this->errors);
    }

    $data = array('filename' => $filename, 'originalFilename' => $file->getClientOriginalName());

    return response()->json(array('data' => $data, 'code' => 200));

  }

  /**
   * Validate if file format is pdf or not
   * 
   * @param  array  $input 
   * @param  array  $rules 
   * @return boolean        
   */
  public function isValidPdf($doc) {

    if($doc->getClientMimeType() == 'application/pdf' && $doc->getClientOriginalExtension() == 'pdf') {
      return true;
    }

    return false;

  }
}

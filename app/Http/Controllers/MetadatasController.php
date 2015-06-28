<?php namespace App\Http\Controllers;

use App\Kokaku\Input\Transformer as Transformer;
use App\Repositories\DocsRepository;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Doc;

class MetadatasController extends BaseController {

  /**
   * Store DocsRepository
   * 
   * @var App\Repositories\DocsRepository
   */
  private $doc;

  /**
   * Constructor
   */
  function __construct() {
    $this->inputTransform = new Transformer;
    $this->doc = new DocsRepository;
  }

  /**
   * Show metadata view
   * @return view
   */
  public function index() {
    return view('app', array('route' => 'metadata'));
  }

  /**
   * Get all metadata
   * @param  string $orderBy
   * @param  string $order  
   * @return json         
   */
  public function all($orderBy = null, $order = 'desc') {
    $sort = array('orderBy' => $orderBy, 'order' => $order);
    return response()->json($this->doc->pagination(5, $sort));
  }

  /**
   * Get complete metadata
   * @param  string $orderBy
   * @param  string $order  
   * @return json         
   */
  public function complete($orderBy = null, $order = 'desc') {
    $sort = array('orderBy' => $orderBy, 'order' => $order);
    return response()->json($this->doc->getCompleteMetadatas(5, $sort));
  }

  /**
   * Get incomplete metadata
   * @param  string $orderBy
   * @param  string $order  
   * @return json         
   */
  public function incomplete($orderBy = null, $order = 'desc') {
    $sort = array('orderBy' => $orderBy, 'order' => $order);
    return response()->json($this->doc->getUncompleteMetadatas(5, $sort));
  }

  /**
   * Get count metadata
   * @return json
   */
  public function getCount() {
    $complete = $this->doc->completeMetadatasCount();
    $uncomplete = $this->doc->uncompleteMetadatasCount();
    $all = $this->doc->count();

    return response()->json(array('complete' => $complete, 'uncomplete' => $uncomplete, 'all' => $all));
  }

  /**
   * Show add view
   * @return view
   */
  public function add() {
    return view('add', array('schema' => $this->doc->getFormSchema('array'), 'route' => 'addMetadata'));
  }

  /**
   * Store new metadata record
   * @return json
   */
  public function store() {
    $metadata = \Request::all();

    $store = $this->doc->storeMetadata($metadata);

    if(!$store) {
      return response()->json($this->doc->errors, 400);
    }

    return response()->json(\Request::all());
  }

  /**
   * Update metadata
   * @param  string $docId
   * @return json       
   */
  public function update($docId) {

    $metadata = \Request::all();

    $update = $this->doc->updateMetadata($metadata, $docId);

    if(!$update) {
      return response()->json($this->doc->errors, 400);
    }

    return response()->json('Successfully update metadata.');

  }

  /**
   * Delete metadata records
   * @return json
   */
  public function destroy() {
    $id = \Request::input('id');

    $destroy = $this->doc->destroy($id);

    if(!$destroy) {
      return response()->json($this->doc->errors);
    }

    return response()->json($destroy);
  }

  /**
   * Get metadata by id
   * @param  string $id
   * @return json    
   */
  public function show($id) {
    return response()->json($this->doc->getMetadataById($id));
  }

  /**
   * Get form schema
   * 
   * @param  string $ext extension
   * @return either array or json
   */
  public function getFormSchema($ext) {
    $extension = explode('.', $ext);

    return response($this->doc->getFormSchema($extension[1]));
  }

}
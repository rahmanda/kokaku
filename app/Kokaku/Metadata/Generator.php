<?php namespace App\Kokaku\Metadata;

/**
 * Generator metadata file  
 */
class Generator extends \XMLWriter {

  /**
   * Target path for storing metadata
   * 
   * @var string
   */
  protected $targetPath = 'docs/';

  /**
   * Storage object
   * 
   * @var \Storage
   */
  protected $storage;

  /**
   * Constructor
   */
  function __construct(){
    $this->storage = new \Storage;

  }

  /**
   * Start metadata generator
   * 
   * @return void
   */
  protected function start() {
    $this->openMemory();
    $this->startDocument('1.0'); 
    $this->setIndent(4); 

    $this->startElement('metadata'); 
    $this->writeAttribute('version', '1.0'); 
    $this->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom'); 
  }

  /**
   * End metadata generator
   * 
   * @return void
   */
  protected function end() {   
    $this->endElement(); 

    $this->endDocument(); 
  }

  /**
   * Main generator
   * 
   * @param  \StdClass  $metadata
   * @param  boolean $child 
   * @return void
   */
  protected function generate($metadata) {
    foreach ($metadata as $item => $value) {
      if(is_array($value)) {
        if($this->is_assoc($value)) {
          $this->startElement($item);
          $this->generate($value);
          $this->endElement();
        } else {
          foreach($value as $it => $val) {
            if(is_array($val)) {
              $this->startElement($item);
              $this->generate($val);
              $this->endElement();
            } else {
              $this->writeElement($item, $val);
            }
          }
        }
      } else {
        $this->writeElement($item, $value);
      }
    }
  }

  function is_assoc($array) {
    return (bool)count(array_filter(array_keys($array), 'is_string'));
  }

  /**
   * Store metadata file to respective path
   * 
   * @param  \StdClass $metadata
   * @param  string $filename
   * @return boolean          
   */
  public function storeMetadata($metadata, $filename) {
    try {
      $this->start();
      $this->generate($metadata);
      $this->end();
      $xml = $this->outputMemory(true);
      $date = $metadata['publishedDate'];
      // list($year, $month, $day) = explode('-', $date);
      // $path = $this->targetPath.$year.'/'.$month.'/'.$filename;
      $path = $this->targetPath.$filename;
      \Storage::put($path, $xml);
    } catch (Exception $e) {
      return false;
    }

    return true;
  }

  /**
   * Change target metadata generation path
   * 
   * @param string $path
   */
  public function setTargetPath($path) {
    $this->targetPath = $path;
  }

}
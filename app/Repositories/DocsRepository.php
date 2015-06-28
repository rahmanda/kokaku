<?php namespace App\Repositories;

use App\Kokaku\Input\Transformer as Transformer;
use App\Kokaku\Metadata\Generator as MetadataGenerator;
use App\Kokaku\Metadata\FormSchema2;
use App\Models\Doc;
use App\Models\Enactment;
use App\Models\UnappliedEffect;
use App\Models\AltDocUrl;
use App\Models\AltSiteUrl;

class DocsRepository extends RepositoryAbstract {

  protected $xsdUrl;

  /**
   * Store Generator
   * 
   * @var App\Kokaku\Metadata\Generator
   */
  private $metadataGenerator;

  /**
   * Store Transformer
   * 
   * @var App\Kokaku\Input\Transformer
   */
  private $inputTransform;

  protected $relations = array('enactment', 'unappliedEffect', 'altDocUrl', 'altSiteUrl');

  /**
   * Constructor
   */
  function __construct() {
    $this->model = new Doc;
    $this->formSchema = new FormSchema2;
    $this->metadataGenerator = new MetadataGenerator;
    $this->inputTransform = new Transformer;
    $this->xsdUrl = storage_path().'/app/metadata.xsd';
  }

  public function getMetadataById($id) {
    return $this->getById($id, $this->relations);
  }

  /**
   * Store metadata and its relationship
   * 
   * @param  array $input
   * @return boolean
   */
  public function storeMetadata($input) {
    $split = explode('.', $input['filename']);
    $filename = $split[0].'.xml';
    $this->generateMetadataFile($input, $filename);

    $doc = $this->inputTransform->doc($input);
    $storeDoc = $this->create($doc);
    
    if(!$storeDoc) {
      return false;
    }

    $enactments = $this->inputTransform->enactments($input);

    if(!empty($enactments)) {
      $storeEnact = $storeDoc->enactment()->create($enactments);
      if(!$storeEnact) {
        return false;
      }
    }

    $unappliedEffects = $this->inputTransform->unappliedEffects($input);

    if(!empty($unappliedEffects)) {
      foreach($unappliedEffects as $ect) {
        $storeUnapplied = $storeDoc->unappliedEffect()->create($ect);
        if(!$storeUnapplied) {
          return false;
        }
      }
    }

    $altDocUrls = $this->inputTransform->altDocUrls($input);

    if(!empty($altDocUrls)) {
      foreach($altDocUrls as $val) {
        $storeAltUrl = $storeDoc->altDocUrl()->create($val);
        if(!$storeAltUrl) {
          return false;
        }
      }
    }

    $altSiteUrls = $this->inputTransform->altSiteUrls($input);

    if(!empty($altSiteUrls)) {
      foreach($altSiteUrls as $val) {
        $storeAltUrl = $storeDoc->altSiteUrl()->create($val);
        if(!$storeAltUrl) {
          return false;
        }
      }
    }

    return true;
  }

  /**
   * Update metadata and its relationship
   * @param  array $input
   * @param  int   $id
   * @return boolean
   */
  public function updateMetadata($input, $id) {
    $split = explode('.', $input['filename']);
    $filename = $split[0].'.xml';
    $this->generateMetadataFile($input, $filename);
    
    $doc = $this->inputTransform->doc($input);
    $saveDoc = $this->update($doc, $id);

    if(!$saveDoc) {
      return false;
    }

    $enactments = $this->inputTransform->enactments($input);

    if(!empty($enactments)) {
      if($enactments['id'] != '') {
        $enact = Enactment::find($enactments['id']);
        $enact->number = $enactments['number'];
        $enact->publishedDate = $enactments['publishedDate'];
        $enact->siteUrl = $enactments['siteUrl'];
        $enact->docUrl = $enactments['docUrl'];
        $saveEnact = $enact->save();

        if(!$saveEnact) {
          return false;
        }
      } else {
        $storeEnact = $this->find($id)->enactment()->create($enactments);
        if(!$storeEnact) {
          return false;
        }
      }
    }

    $unappliedEffects = $this->inputTransform->unappliedEffects($input);

    if(!empty($unappliedEffects)) {
      foreach($unappliedEffects as $value) {
        if($value['id'] != '') {
          $unapplied = UnappliedEffect::find($value['id']);
          $unapplied->docNumber = $value['docNumber'];
          $unapplied->status = $value['status'];
          $saveUnapplied = $unapplied->save();

          if(!$saveUnapplied) {
            return false;
          }
        } else {
          $storeUnapplied = $this->find($id)->unappliedEffect()->create($value);
          if(!$storeUnapplied) {
            return false;
          }
        }
      }
    }

    $altDocUrls = $this->inputTransform->altDocUrls($input);

    if(!empty($altDocUrls)) {
      foreach($altDocUrls as $value) {
        if($value['id'] != '') {
          $altDocUrl = AltDocUrl::find($value['id']);
          $altDocUrl->altDocUrl = $value['altDocUrl'];
          $saveAltUrl = $altDocUrl->save();
          if(!$saveAltUrl) {
            return false;
          }
        } else {
          $storeAltUrl = $this->find($id)->altDocUrl()->create($value);
          if(!$storeAltUrl) {
            return false;
          }
        }
      }
    }

    $altSiteUrls = $this->inputTransform->altSiteUrls($input);

    if(!empty($altSiteUrls)) {
      foreach($altSiteUrls as $value) {
        if($value['id'] != '') {
          $altSiteUrl = AltSiteUrl::find($value['id']);
          $altSiteUrl->altSiteUrl = $value['altSiteUrl'];
          $saveAltUrl = $altSiteUrl->save();
          if(!$saveAltUrl) {
            return false;
          }
        } else {
          $storeAltUrl = $this->find($id)->altSiteUrl()->create($value);
          if(!$storeAltUrl) {
            return false;
          }
        }
      }
    }

    return true;
  }

  /**
   * Get XSD path url
   * 
   * @return string
   */
  public function getXsdUrl() {
    return $this->xsdUrl;
  }

  /**
   * Set XSD path url
   * 
   * @param string $xsdUrl
   */
  public function setXsdUrl($xsdUrl) {
    $this->xsdUrl = $xsdUrl;
  }

  /**
   * Get form schema
   * 
   * @param  string $ext extension
   * @return array
   */
  public function getFormSchema($ext) {
    $schema = file_get_contents($this->xsdUrl);
    return $this->formSchema->getFormSchema($schema, $ext);
  }

  /**
   * Generate metadata file
   * 
   * @return json
   */
  public function generateMetadataFile($metadata, $filename) {
    $generate = $this->metadataGenerator->storeMetadata($metadata, $filename);

    if($generate) {
      return true;
    }
    return false;
  }

  /**
   * Get all metadatas
   * 
   * @param  integer $items
   * @param  array   $with 
   * @return Paginator       
   */
  public function pagination($items = 30, array $order = array(), array $with = array()) {

    if(empty($order)) {
      $entity = $this->make($with);
    } else {
      $entity = $this->make($with)->orderBy($order['orderBy'], $order['order']);
    }
    
    return $entity->paginate($items);
  }

  /**
   * Get complete metadatas
   * @param  integer $items
   * @param  array   $with 
   * @return Paginator        
   */
  
  public function getCompleteMetadatas($items = 30, array $order = array(), array $with = array()) {

    if(empty($order)) {
      $metadatas = $this->make($with)->where('title', '!=', '')->where('filename','!=', '')->where('originalFilename', '!=', '')->where('number', '!=', '')->where('docType', '!=', '')
      ->where('publishedDate', '!=', '0000-00-00')->where('validDate', '!=', '0000-00-00')->where('docUrl', '!=', '');
    } else {
      $metadatas = $this->make($with)->where('title', '!=', '')->where('filename','!=', '')->where('originalFilename', '!=', '')->where('number', '!=', '')->where('docType', '!=', '')
      ->where('publishedDate', '!=', '0000-00-00')->where('validDate', '!=', '0000-00-00')->where('docUrl', '!=', '')->orderBy($order['orderBy'], $order['order']);
    }
    
    return $metadatas->paginate($items);
  }

  /**
   * Get uncomplete metadatas
   * 
   * @param  integer $items 
   * @param  array   $with 
   * @return Paginator        
   */

  public function getUncompleteMetadatas($items = 30, array $order = array(), array $with = array()) {
    if(empty($order)) {
      $metadatas = $this->make($with)->where('title', '')->orWhere('filename', '')->orWhere('originalFilename', '')->orWhere('number', '')->orWhere('docType', '')
      ->orWhere('publishedDate', '0000-00-00')->orWhere('validDate', '0000-00-00')->orWhere('docUrl', '');
    } else {
      $metadatas = $this->make($with)->where('title', '')->orWhere('filename', '')->orWhere('originalFilename', '')->orWhere('number', '')->orWhere('docType', '')
      ->orWhere('publishedDate', '0000-00-00')->orWhere('validDate', '0000-00-00')->orWhere('docUrl', '')->orderBy($order['orderBy'], $order['order']);
    }
    return $metadatas->paginate($items);
  }

  /**
   * Get total complete metadatas
   * 
   * @param  array  $with
   * @return integer     
   */

  public function completeMetadatasCount(array $with = array()) {
    return $this->make($with)->where('title', '!=', '')->where('filename','!=', '')->where('originalFilename', '!=', '')->where('number', '!=', '')->where('docType', '!=', '')
      ->where('publishedDate', '!=', '0000-00-00')->where('validDate', '!=', '0000-00-00')->where('docUrl', '!=', '')->count();
  }

  /**
   * Get total uncomplete metadatas
   * 
   * @param  array  $with
   * @return integer      
   */

  public function uncompleteMetadatasCount(array $with = array()) {
    return $this->make($with)->where('title', '')->orWhere('filename', '')->orWhere('originalFilename', '')->orWhere('number', '')->orWhere('docType', '')
      ->orWhere('publishedDate', '0000-00-00')->orWhere('validDate', '0000-00-00')->orWhere('docUrl', '')->count();
  }
}
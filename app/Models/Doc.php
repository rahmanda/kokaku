<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model implements RuleInterface {

  public static $uploadRule = array(
    'doc' => 'required|mimes:pdf'
    );

  protected $fillable = array('title', 'filename', 'originalFilename', 'number', 'docType', 
    'publishedDate', 'validDate', 'docUrl', 'siteUrl', 'description');

  protected $rules = array(
    'title'         => 'string',
    'filename'      => 'required|string',
    'originalFilename' => 'required|string',
    'number'        => 'string',
    'docType'       => 'string',
    'publishedDate' => 'required|string',
    'validDate'     => 'string',
    'docUrl'        => 'string'
    );

  protected $hidden = array('updated_at');

  public static $snakeAttributes = false;

  public function getRules() {
    return $this->rules;
  }

  public function enactment() {
    return $this->hasOne('App\Models\Enactment', 'docId');
  }

  public function unappliedEffect() {
    return $this->hasMany('App\Models\UnappliedEffect', 'docId');
  }

  public function altDocUrl() {
    return $this->hasMany('App\Models\AltDocUrl', 'docId');
  }

  public function altSiteUrl() {
    return $this->hasMany('App\Models\AltSiteUrl', 'docId');
  }

}
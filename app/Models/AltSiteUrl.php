<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AltSiteUrl extends Model implements RuleInterface {

  protected $table = 'altSiteUrls';

  protected $rules = array(
    'altSiteUrl'         => 'required|string'
    );

  protected $fillable = array('docId', 'altSiteUrl');

  protected $hidden = array('docId');

  public $timestamps = false;

  public static $snakeAttributes = false;

  public function getRules() {
    return $this->rules;
  }

  public function doc() {
    return $this->belongsTo('Doc');
  }

}
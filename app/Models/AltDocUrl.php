<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AltDocUrl extends Model implements RuleInterface {

  protected $table = 'altDocUrls';

  protected $rules = array(
    'altDocUrl'         => 'required|string'
    );

  protected $fillable = array('docId', 'altDocUrl');

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
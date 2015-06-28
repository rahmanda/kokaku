<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enactment extends Model implements RuleInterface {

  protected $table = 'enactments';

  protected $fillable = array('number', 'publishedDate', 'docName', 
                              'docId', 'siteUrl', 'docUrl');

  protected $rules = array(
    'number'        => 'required|string',
    'publishedDate' => 'required',
    'docName'       => 'required|string',
    );

  protected $hidden = array('created_at', 'updated_at', 'docId');

  public static $snakeAttributes = false;

  public function getRules() {
    return $this->rules;
  }

  public function doc() {
    return $this->belongsTo('Doc');
  }

}
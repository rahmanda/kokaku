<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnappliedEffect extends Model implements RuleInterface {

  protected $table = 'unappliedEffects';

  protected $rules = array(
    'docNumber'        => 'required|string',
    'status'        => 'string'
    );

  protected $fillable = array('docId', 'docNumber', 'status');

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
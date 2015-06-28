<?php namespace App\Kokaku\Input;

/**
 * Transform array Schema input into acceptable Eloquent input array
 * Expects function process to be called first after instantiation
 */
class Transformer {

  protected $input = array();

  public function doc($input) {
    return $this->simpleType($input);
  }

  public function altDocUrls($input) {
    return $this->simpleType($input, 'altDocUrl');
  }

  public function altSiteUrls($input) {
    return $this->simpleType($input, 'altSiteUrl');
  }

  public function unappliedEffects($input) {
    return $this->simpleType($input, 'unappliedEffect');
  }

  public function publisher($input) {
    return $this->simpleType($input, 'publisher');
  }

  public function enactments($input) {
    return $this->simpleType($input, 'enactment');
  }

  protected function simpleType($input, $key = null) {
    if($key == null) {
       /**
       * unset all possible unrelated fields
       */
      unset($input['publisher']);
      unset($input['altDocUrl']);
      unset($input['altSiteUrl']);
      unset($input['enactment']);
      unset($input['unappliedEffect']);

      return $input;
    } else {
      return $input[$key];
    }
  }

}
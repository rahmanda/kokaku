<?php namespace App\Repositories;

use App\Models\AltDocUrl;

class AltDocUrlsRepository extends RepositoryAbstract {

  /**
   * Constructor
   */
  function __construct() {
    $this->model = new AltDocUrl;
  }
}
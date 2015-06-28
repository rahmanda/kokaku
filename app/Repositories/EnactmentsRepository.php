<?php namespace App\Repositories;

use App\Models\Enactment;

class EnactmentsRepository extends RepositoryAbstract {

  /**
   * Constructor
   */
  function __construct() {
    $this->model = new Enactment;
  }
}
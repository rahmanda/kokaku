<?php namespace App\Repositories;

use App\Models\AltSiteUrl;

class AltSiteUrlsRepository extends RepositoryAbstract {

  /**
   * Constructor
   */
  function __construct() {
    $this->model = new AltSiteUrl;
  }
}
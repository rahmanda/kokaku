<?php namespace App\Repositories;

interface RepositoryInterface {

  public function create($input);

  public function update($input, $id);

  public function find($id);

  public function destroy($id);

  public function isValid($input, $rules);

}
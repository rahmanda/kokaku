<?php namespace App\Repositories;

abstract class RepositoryAbstract implements RepositoryInterface {

  /**
   * Store model
   * 
   * @var Model
   */
  public $model;

  /**
   * Store errors
   * 
   * @var array
   */
  public $errors = array();

  /**
   * Return all users
   * 
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function all() {
    return $this->model->all();
  }

  /**
   * Create new model for user
   * 
   * @param  array $input
   * @return Model
   */
  public function create($input) {

    if(!$this->isValid($input, $this->model->getRules())) {
      return false;
    }

    if ($response = $this->model->create($input)) {
      return $response;
    } else {
      array_push($this->errors, 'Could not create new record.');
      return false;
    }

  }

  /**
   * Update model
   * 
   * @param  array $input
   * @param  int $id   
   * @return Response       
   */
  public function update($input, $id) {
    $model = $this->find($id);

    if(!$this->isValid($input, $this->model->getRules())) {
      return false;
    }

    $model->fill($input);

    return $model->save();
  }

  /**
   * Find model by id
   * 
   * @param  int $id
   * @return Response    
   */
  public function find($id) {
    $model = $this->model->find($id);

    if(!$model) {
      array_push($this->errors,
        'Could not find record with id = '.$id.'.');
      return false;
    }

    return $model;
  }

  /**
   * Destroy model
   * 
   * @param  int $id
   * @return int    
   */
  public function destroy($id) {
    $model = $this->getById($id);

    if(!$delete = $model->delete()) {
      array_push($this->errors,
        'Could not delete a record.');
      return false;
    } 

    return $delete;
  }

  /**
   * Check if input valid against rules
   * 
   * @param  array  $input
   * @param  array  $rules
   * @return boolean       
   */
  public function isValid($input, $rules) {

    $validator = \Validator::make($input, $rules);

    if($validator->passes()) {
      return true;
    }

    array_push($this->errors, $validator->messages());
    
    return false;
  }

  /**
   * Make a new instance of the entity to query on
   *
   * @param array $with
   */
  public function make(array $with = array())
  {
    return $this->model->with($with);
  }

  /**
   * Find an entity by id
   *
   * @param int $id
   * @param array $with
   * @return Illuminate\Database\Eloquent\Model
   */
  public function getById($id, array $with = array())
  {
    $query = $this->make($with);
   
    return $query->find($id);
  }

  /**
   * Find a single entity by key value
   *
   * @param string $key
   * @param string $value
   * @param array $with
   */
  public function getFirstBy($key, $value, array $with = array())
  {
    $this->make($with)->where($key, '=', $value)->first();
  }
   
  /**
   * Find many entities by key value
   *
   * @param string $key
   * @param string $value
   * @param array $with
   */
  public function getManyBy($key, $value, array $with = array())
  {
    $this->make($with)->where($key, '=', $value)->get();
  }

  /**
   * Get Results by Page
   *
   * @param int $page
   * @param int $limit
   * @param array $with
   * @return StdClass Object with $items and $totalItems for pagination
   */
  public function getByPage($page = 1, $limit = 30, $with = array())
  {
    $result             = new \StdClass;
    $result->page       = $page;
    $result->totalPage  = 0;
    $result->limit      = $limit;
    $result->totalItems = 0;
    $result->items      = array();

    $query = $this->make($with);

    $model = $query->skip($limit * ($page - 1))
    ->take($limit)
    ->get();

    $result->totalItems = $this->model->count();
    $result->items      = $model->all();

    return $result;
  }

  /**
   * Return all results that have a required relationship
   *
   * @param string $relation
   */
  public function has($relation, array $with = array())
  {
    $entity = $this->make($with);
    
    return $entity->has($relation)->get();
  }

  public function count(array $with = array())
  {
    return $this->make($with)->count();
  }

}
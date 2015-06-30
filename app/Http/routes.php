<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$app->get('/', function() {
  return view('login');
});

$app->get('login', function() {
  return view('login');
});

$app->get('register', array('as' => 'register', function() {
  return view('register');
}));

$app->post('upload', array('as' => 'upload', 'uses' => 'App\Http\Controllers\UploadController@upload'));

$app->group(array('prefix' => 'metadata', 'namespace' => 'App\Http\Controllers'), function($app) {

  $app->get('', array('as' => 'metadata','uses' => 'MetadatasController@index'));
  $app->get('count', array('as' => 'countMetadata', 'uses' => 'MetadatasController@getCount'));
  $app->post('', array('uses' => 'MetadatasController@store'));
  $app->put('{docId}', array('uses' => 'MetadatasController@update'));
  $app->get('formSchema{ext}', array('as' => 'formSchema', 'uses' => 'MetadatasController@getFormSchema'));
  $app->get('item/{id}', array('uses' => 'MetadatasController@show'));
  $app->get('view/{id}', function($id) {
    return view('view', array('route' => 'view', 'itemId' => $id));
  });
  $app->get('add', array('as' => 'addMetadata','uses' => 'MetadatasController@add'));
  $app->get('fetchIncomplete/{orderBy}/{order}', array('uses' => 'MetadatasController@incomplete'));
  $app->get('fetchComplete/{orderBy}/{order}', array('uses' => 'MetadatasController@complete'));
  $app->get('fetchAll/{orderBy}/{order}', array('uses' => 'MetadatasController@all'));

});


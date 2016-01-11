<?php

require 'vendor/autoload.php';
require 'config.php';
require 'Auth.php';
require 'Classes.php';
require 'SlimDoc.php';

if (DEV === 1) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  ini_set("auto_detect_line_endings", true);
  error_reporting(-1);
}

$app = new \Slim\Slim(array( 'debug' => DEV ));
$auth = new Auth($app);
$parsedown = new Parsedown();

// Generates Documentation for Slim Routes
$app->get('/', 'getDocs');

// Resource Routes
$app->group('/resources', function () use ($app, $auth) {
  $app->get('/(:resourceId)',
    $auth->belongsTo('group'),
    $auth->checkRole('admin'),
    'getResource');
  $app->post('/',
    $auth->belongsTo('group'),
    $auth->checkRole('admin'),
    'postResource');
  $app->put('/:resourceId',
    $auth->belongsTo('group'),
    $auth->checkRole('admin'),
    'putResource');
  $app->delete('/:resourceId',
    $auth->belongsTo('group'),
    $auth->checkRole('admin'),
    'deleteResource');
});

// GET Docs
function getDocs() {
  global $parsedown;

  echo '<style>'.'body{ font-family:arial; }'.'</style>';
  echo $parsedown->text( SlimDoc::listRoutes() );
}

// GET Resource
function getResource($resourceId = 0) {
  global $app;

  // SELECT Resource
  if ($resourceId == 0) {
    $resource = Resource::with('relation1')->get();
  } else {
    $resource = Resource::with('relation1')->find($resourceId);
    $resource->relation2();
  }

  if ($resource) {
    $app->response->setStatus(200);
    echo $resource->toJson();
  } else {
    $app->response->setStatus(400);
    echo '{"error":{"text":"request failed"}}';
  }
}

// POST Resource
function postResource($resourceId = 0) {
  global $app;

  // INSERT Resource
  $resource = new Resource;
  $resource->param1 = 'hello';
  $resource->param2 = 'world';
  $resource->save();

  if ($resource) {
    $app->response->setStatus(200);
    echo $resource->toJson();
  } else {
    $app->response->setStatus(400);
    echo '{"error":{"text":"request failed"}}';
  }
}

// PUT Resource
function putResource($resourceId = 0) {
  global $app;

  // UPDATE Resource
  $resource = Resource::find($resourceId);
  $resource->param1 = 'hello';
  $resource->param2 = 'world';
  $resource->save();

  if ($resource) {
    $app->response->setStatus(200);
    echo $resource->toJson();
  } else {
    $app->response->setStatus(400);
    echo '{"error":{"text":"request failed"}}';
  }
}

// DELETE Resource
function deleteResource($resourceId) {
  global $app;

  // DELETE Resource
  $resource = Resource::find($resourceId);
  $count = $cabin->delete();

  if ($count > 0) {
    $app->response->setStatus(200);
    echo $resource->toJson();
  } else {
    $app->response->setStatus(400);
    echo '{"error":{"text":"request failed"}}';
  }
}

?>

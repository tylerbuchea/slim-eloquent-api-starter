<?php

Class SlimDocRouter extends \Slim\Router {
  public static function getter() {
    $slim = \Slim\Slim::getInstance();
    $routes = $slim->router->routes;
    return $routes;
  }
}

Class SlimDocRoute extends \Slim\Route {
  public static function getter($routes) {

    $docs = '#Documentation';

    foreach($routes as $route) {
      /*
        all possible $route params:
        pattern, callable, conditions, defaultConditions,
        name, params, paramNames, paramNamesPath, methods[],
        middleware
      */
      $docs = $docs.
        '<h2>'. $route->pattern .'</h2>'.
        '<h3>'. $route->methods[0] .'</h3>'.
        '<h4>'. $route->callable .'</h4>'.
        '<br>';
    }

    return $docs;

  }
}

Class SlimDoc {

  public static function listRoutes() {

    return SlimDocRoute::getter( SlimDocRouter::getter() );

  }

  public static function getRoutes() {
    $slim = \Slim\Slim::getInstance();
    $routes = $slim->router->routes;
    return $routes;
  }

  public static function parseRoutes($routes) {
    $docs = '#Documentation';

    foreach($routes as $route) {
      /*
        all possible $route params:
        pattern, callable, conditions, defaultConditions,
        name, params, paramNames, paramNamesPath, methods[],
        middleware
      */
      $docs = $docs.
        '<h2>'. $route->pattern .'</h2>'.
        '<h3>'. $route->methods[0] .'</h3>'.
        '<h4>'. $route->callable .'</h4>'.
        '<br>';
    }

    return $docs;
  }

}

?>
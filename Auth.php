<?php

class Auth {

  // globals
  public $app = null;

  // construct
  function __construct($appReference) {
    $app = $appReference;
  }

  // belongs to
  public static function belongsTo ( $group = '' ) {
    return function ( $route ) use ( $group ) {
      global $app;

      $cookies = $app->request->cookies;
      $params = $route->getParams();

      $belong = false;
      $userId = $cookies['user_id'];

      switch ($group) {

        case 'user':
          $userId2 = $params['userId'];

          if ( (int) $userId === (int) $userId2 ) {
            $belong = true;
          }
          break;

        case 'group2':
          $bookingNumber = $params['bookingNumber'];
          $userBooking = Fathom::getUserBooking($userId, $bookingNumber);

          if ($userBooking) {
            $belong = true;
          }
          break;

      }

      $routeParams = $route->getParams();

      if (!is_array($routeParams)) {
        $routeParams = array();
      }

      $routeParams['belongsTo'] = $belong;
      $route->setParams($routeParams);

    };
  }

  // check role
  public static function checkRole ( $roleName = 'traveler' ) {
    return function ( $route ) use ( $roleName ) {
      global $app;

      $cookies = $app->request->cookies;
      $params = $route->getParams();

      (int) $userId = $cookies['user_id'];
      $token = $cookies['user_token'];
      (bool) $belong = ( isset($params['belongsTo']) ) ? $params['belongsTo'] : false;

      // Get Session
      $session = Fathom::getSession($userId, $token);
      if (!$session) {
        $app->response->setStatus(400);
        echo '{"error":{"text":"no session"}}';
        $app->stop();
      }

      // Verify Token
      if ($session->token !== $token) {
        $app->response->setStatus(400);
        echo '{"error":{"text":"token not valid"}}';
        $app->stop();
      }

      $userRoleValue = (int) $session->userrolevalue;

      // If user doesn't belong check role
      if (!$belong) {

        $routeRoleValue = (int) Fathom::getRoleValue($roleName);

        if ( $userRoleValue < $routeRoleValue ) {
          $app->response->setStatus(400);
          echo '{"error":{"text":"user role insufficient"}}';
          $app->stop();
        }

      }

      $routeParams = $route->getParams();

      if (!is_array($routeParams)) {
        $routeParams = array();
      }

      $routeParams['roleName'] = $session->userrolename;
      $routeParams['roleValue'] = $session->userrolevalue;
      $route->setParams($routeParams);
    };
  }

}

?>

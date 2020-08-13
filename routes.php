<?php

use Project\Components\Route;
use Project\Controllers\AuthController;
use Project\Controllers\IndexController;

return [
  '/' => new Route(IndexController::class, 'index'),
  '/login' => new Route(AuthController::class, 'login'),
  '/register' => new Route(AuthController::class, 'register'),
  '/logout' => new Route(AuthController::class, 'logout'), //post only
];
<?php

use Project\Components\Route;
use Project\Controllers\AdminController;
use Project\Controllers\AuthController;
use Project\Controllers\IndexController;
use Project\Controllers\QuizRpcController;

return array(
  '/' => new Route(IndexController::class, 'index') ,
  '/login' => new Route(AuthController::class, 'login'),
  '/register' => new Route(AuthController::class, 'register'),
  '/logout' => new Route(AuthController::class, 'logout'), //post only
  '/dashboard' => new Route(IndexController::class, 'dashboard'),
  '/my-results' => new Route(IndexController::class, 'myResults'),
  '/admin' => new Route(AdminController::class, 'index'),
  '/quiz-rpc/get-all' => new Route(QuizRpcController::class, 'getAll'),
  '/quiz-rpc/start' => new Route(QuizRpcController::class, 'startQuiz'),
  '/quiz-rpc/get-question' => new Route(QuizRpcController::class, 'getQuestion'),
  '/quiz-rpc/save-answer' => new Route(QuizRpcController::class, 'saveAnswer'),
  '/quiz-rpc/get-results' => new Route(QuizRpcController::class, 'getResults'),
 // '/delete/user/'.$_POST['identity'] => new Route(AdminController::class, 'deleteUser',$_POST['identity']),
 // '/edit/user/'.$_POST['identity'] => new Route(AdminController::class, 'editUser',$_POST['identity']),
  '/admin/toggle-user-admin' => new Route(AdminController::class, 'toggleUserAdmin', [Route::METHOD_POST]),
  '/admin/view-user' => new Route(AdminController::class, 'viewUser', [Route::METHOD_GET]),
  '/admin/view-quiz' => new Route(AdminController::class, 'viewQuiz', [Route::METHOD_GET]),
  '/admin/delete-user' => new Route(AdminController::class, 'deleteUser', [Route::METHOD_POST]),
);
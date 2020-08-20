<?php


use Project\Components\Session;


require_once '../bootstrap/app.php';

$routes = require_once '../routes.php'; //routes.php atgriež routes masivu no routes.php

$path = parse_url($_SERVER['REQUEST_URI'])['path']; //prase url izvelk visus paths lidz '?'


//if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//    if($_POST['csrf'] !== Session::getInstance()->getCsrf()){
//       throw new Exception('Invalid CSRF');
//    }
//}

(new \Project\Components\Router($routes, $path))->resolve();

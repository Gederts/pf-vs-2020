<?php



require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

$routes = require_once '../routes.php'; //routes.php atgriež routes masivu no routes.php

$path = parse_url($_SERVER[ 'REQUEST_URI'])['path']; //prase url izvelk visus paths lidz '?'

(new \Project\Components\Router($routes, $path))->resolve();
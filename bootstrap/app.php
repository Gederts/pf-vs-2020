<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Project\Components\Session;

defined('PROJECT_ROOT') or define('PROJECT_ROOT', dirname(__DIR__));
defined('PROJECT_VIEW_DIR') or define('PROJECT_VIEW_DIR', PROJECT_ROOT.'/resources/views');
defined('PROJECT_LAYOUT_DIR') or define('PROJECT_LAYOUT_DIR', PROJECT_ROOT.'/resources/layouts');


Dotenv::createImmutable(PROJECT_ROOT)->load();

session_start();

Session::getInstance()->generateCsrf();

$capsule = new Capsule();
$capsule->addConnection(
    [
        "driver" => "mysql",
        "host" => env('DB_HOST'),
        "database" => env('DB_NAME'),
        "username" => env('DB_USER'),
        "password" => env('DB_PASS'),
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci",
    ]
);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();



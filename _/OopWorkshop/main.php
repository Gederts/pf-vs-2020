<?php

use PF\Cat;
use PF\Dog;

require_once 'vendor/autoload.php';

$muris = new Dog('muris');
$reksis = new Cat('reksis');
$reksis->run();
$muris->run();
$reksis->run();

$muris->sleep();
$muris->sleep();
$muris->sleep();
$muris->sleep();
var_dump($muris);
var_dump($reksis);

var_dump(Dog::$animalCount);

Dog::foo();

class A{
    public static $foo = 'a';
    public static function foo(): string
    {
        return self::$foo;
    }
}

class B extends A{
    public static $foo = 'b';
}
class C extends A{
    public static $foo = 'c';
}
var_dump(B::foo());
var_dump(C::foo());
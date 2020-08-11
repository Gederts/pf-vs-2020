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
    public static string $foo = 'a';
    public static function foo(): string
    {
        return self::$foo;
    }
}

class B extends A{
    public static string $foo = 'b';
}
class C extends A{
    public static string $foo = 'c';
}


var_dump(B::foo());
var_dump(C::foo());
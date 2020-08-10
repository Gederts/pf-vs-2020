<?php
namespace PF;

class Parrot extends Animal implements Flyable
{
    public function fly()
    {
        $this->energy -= 3;
    }
}
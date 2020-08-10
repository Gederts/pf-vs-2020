<?php

namespace PF;
class Dog extends Animal
{
    use ChaisesBirds;

    public function run(): void
    {
        $this->energy -= 2;
    }
}
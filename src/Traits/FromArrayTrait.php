<?php

namespace Project\Traits;

trait FromArrayTrait        //ielasa dataus no visām formām
{
    public static function fromArray(array $data = [])
    {
        $class = new static();

        foreach ($data as $property => $value) {
            if (property_exists($class, $property)) {
                $class->{$property} = $value;
            }
        }

        return $class;
    }
}

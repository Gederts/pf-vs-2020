<?php

namespace Project\Traits;

trait FromArrayTrait
{
    public static function fromarray(array $data = [])
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

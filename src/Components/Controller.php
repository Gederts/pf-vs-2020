<?php


namespace Project\Components;


abstract class Controller
{
    public function view(string $name, array $data = []): string  //htmls view izvads ir gara simbolu virkne
    {
        //TODO: Izveidos jaunu view klasi, saliks datus, izvadīs/atgriezīs skatu
        return (new View($name, $data, 'layout'))->render();
    }
}
<?php


namespace Project\Components;


abstract class Controller
{
    public function view(string $name, array $data = []): ?string  //htmls view izvads ir gara simbolu virkne
    {
        return (new View($name, $data))->render();
    }

    public function redirect(string $path)
    {
        header("Location: $path");

        return null;
    }
}
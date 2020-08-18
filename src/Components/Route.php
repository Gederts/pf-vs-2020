<?php


namespace Project\Components;


class Route
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    private string $controllerClass;
    private string $action;
    //protected ?string $parameter;
    private ?array $allowedMethods;

    public function __construct(string $controllerClass, string $action/*, string $parameter = null*/, array $allowedMethods = [])
    {
        $this->controllerClass = $controllerClass;
        $this->action = $action;
       // $this->parameter = $parameter;
        $this->allowedMethods = $allowedMethods;
    }

    public function getControllerClass():string
    {
        return $this->controllerClass;
    }

    public function getAction():string
    {
        return $this->action;
    }

    /*public function getParameter():?string
    {
        return $this->parameter;
    }

    public function setParameter(string $param)
    {
        $this->parameter=$param;
    }*/
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}
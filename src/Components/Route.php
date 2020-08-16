<?php


namespace Project\Components;


class Route
{
    private string $controllerClass;
    private string $action;
    protected ?string $parameter;


    public function __construct(string $controllerClass, string $action, string $parameter = null)
    {
        $this->controllerClass = $controllerClass;
        $this->action = $action;
        $this->parameter = $parameter;
    }

    public function getControllerClass():string
    {
        return $this->controllerClass;
    }

    public function getAction():string
    {
        return $this->action;
    }

    public function getParameter():?string
    {
        return $this->parameter;
    }

    public function setParameter(string $param)
    {
        $this->parameter=$param;
    }

}
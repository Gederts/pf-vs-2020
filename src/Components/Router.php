<?php


namespace Project\Components;


use Exception;
use Project\Controllers\ErrorController;

class Router
{
    private array $routes;
    private string $path;

    public function __construct(array $routes, string $path)
    {
        $this->routes = $routes;
        $this->path = $path;
    }

    /**
     * @throws Exception
     *
     */
    public function resolve(): void
    {

        $route = $this->routes[$this->path] ?? new Route(ErrorController::class, 'notFound');

        $third = explode('/', $this->path);


        if (!method_exists($route->getControllerClass(), $route->getAction())) {
            throw new Exception("Action '{$route->getAction()}' not found in '{$route->getControllerClass()}'");
        }
        $controllerClass = $route->getControllerClass();
        $controller = new $controllerClass;

        if ($third[3] !== null){
            $route->setParameter($third[3]);
        }


        echo call_user_func([$controller, $route->getAction()], $route->getParameter());
    }
}
<?php

namespace App\Core;

class Route
{
    const PATH_CONTROLLERS = '\\App\Controllers\\';
    private array $routes = [];
    private $controllerName;
    private $methodName;
    private bool $startCheck = false;

    public function addRoute(string $path, $controller, string $methodName)
    {
        $this->routes[$path] = [$controller, $methodName];
    }

    public function getControllerName(): ?string
    {
        if (!$this->startCheck) {
            $this->run();
        }
        return $this->controllerName;
    }

    public function getMethodName(): ?string
    {
        if (!$this->startCheck) {
            $this->run();
        }
        return $this->methodName;
    }

    private function run()
    {
        if (!$this->startCheck) {
            $requestUri = parse_url($_SERVER['REQUEST_URI']);
            $path = $requestUri['path'];
            $route = $this->routes[$path] ?? null;
            if ($route) {
                $this->controllerName = $route[0];
                $this->methodName = $route[1];
            } else {
                $path = explode('/', $path);
                $this->controllerName = self::PATH_CONTROLLERS . ucfirst(strtolower($path[1]));
                $this->methodName = strtolower($path[2] ?? 'index');
            }
            $this->startCheck = true;
        }
    }
}

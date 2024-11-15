<?php

namespace Core;

require_once BASE_PATH . '/src/handlers/constants.php';
require_once BASE_PATH . '/src/handlers/product.php';
require_once BASE_PATH . '/src/handlers/category.php';

class Router
{
    protected $routes = [];
    public function add($method, $uri, $controller, $middlewares = [])
    {
    
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middlewares' => $middlewares
        ];

        return $this;
    }

    public function get($uri, $controller, $middlewares = [])
    {
        return $this->add('GET', $uri, $controller, $middlewares);
    }

    public function post($uri, $controller, $middlewares = [])
    {
        return $this->add('POST', $uri, $controller, $middlewares);
    }

    public function delete($uri, $controller, $middlewares = [])
    {
        return $this->add('DELETE', $uri, $controller, $middlewares);
    }

    public function patch($uri, $controller, $middlewares = [])
    {
        return $this->add('PATCH', $uri, $controller, $middlewares);
    }

    public function put($uri, $controller, $middlewares = [])
    {
        return $this->add('PUT', $uri, $controller, $middlewares);
    }
    /*
    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }
    */

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            
            $pattern = $this->getPattern($route['uri']);
            if(preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                array_shift($matches);
                $middlewares = $route['middlewares'];
                foreach($middlewares as $middleware) {
                    $midd = 'Core\\' .$middleware;
                    if(function_exists($midd)) {
                        $midd();
                    } 
                }
                $controller = $route['controller'];
                if (is_array($controller) && count($controller) === 2) {
                    [$class, $action] = $controller;
                    if (class_exists($class) && method_exists($class, $action)) {
                        call_user_func([$class, $action]);
                        return;
                    }
                } else {
                    return require base_path('/src/controllers/' . $controller);
                }
            }
        }
        $this->abort();
    }
    


    public function getPattern($uri)
    {
        $pattern = preg_replace_callback('/\/\:([^\/]+)/', function($matches) {
            return '/([^\/]+)';
        }, $uri);
        
        return "~^$pattern$~";
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        die();
    }
}
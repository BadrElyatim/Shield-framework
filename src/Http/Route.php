<?php

namespace Shield\Http;

class Route {

    protected Request $request;

    protected Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    protected static array $routes = [];

    public static function get($route, callable|array $action) {
        self::$routes['get'][$route] = $action;
    }

    public static function post($route, callable|array $action) {
        self::$routes['post'][$route] = $action;
    }

    public function resolve() {
        $method = $this->request->method();
        $path = $this->request->path();

        $action = self::$routes[$method][$path] ?? false;

        if (!$action) return;

        if (is_callable($action)) {
            call_user_func($action);
        }
        else if (is_array($action)) {
            
            call_user_func_array([new $action[0], $action[1]], []);
        }
    }
}
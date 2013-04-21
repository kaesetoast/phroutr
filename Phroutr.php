<?php
class Phroutr {
    private $uriLevelOffset = 1;
    public static $instance = null;
    private $routes = array();

    private function __construct() {
    }

    public function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Phroutr();
        }
        return self::$instance;
    }

    public function define($route, $controller, $action) {
        $this->routes[$route] = array('controller' => $controller, 'action' => $action);
    }

    public function parse() {
        $uri = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $pattern => $route) {
            if ($uri == $pattern) {
                $controller = new $route['controller'];
                $action = $route['action'];
                return call_user_func_array(array($controller, $action), array());
            }
        }
    }
}
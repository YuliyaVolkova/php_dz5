<?php

namespace App\Core;

use Exception;

class Router
{
    protected $routes;
    protected $cClass;
    protected $cFile;
    public $cName = 'MainController';
    public $cAction = 'index';

    protected function getRoutes()
    {
        return $this->routes = explode('/', $_SERVER['REQUEST_URI']);
    }

    protected function setFileName(bool $flag)
    {
        $cDefaultFile = APPLICATION_PATH . 'Core/' . $this->cName . '.php';
        return $this->cFile = ($flag) ? APPLICATION_PATH . 'Controllers/' . $this->cName . '.php' : $cDefaultFile;
    }

    protected function setControllerClass(bool $flag)
    {
        $cDefaultClass = '\App\Core\\' . $this->cName;
        return $this->cClass = ($flag) ? '\App\Controllers\\' . $this->cName : $cDefaultClass;
    }

    protected function setControllerName()
    {
        if (empty($this->routes[1])) {
            $this->setFileName(false);
            $this->setControllerClass(false);
        } else {
            $this->cName = ucfirst(strtolower($this->routes[1]));
            $this->setFileName(true);
            $this->setControllerClass(true);
        }
        return false;
    }

    protected function setControllerAction()
    {
        if (!empty($this->routes[2])) {
            return $this->cAction = $this->routes[2];
        }
        return false;
    }

    protected function redirect()
    {
        try {
            if (!file_exists($this->cFile)) {
                throw new Exception('Controller file not found');
            }
            if (class_exists($this->cClass)) {
                $controller = new $this->cClass();
            } else {
                throw new Exception('File found but Class not found');
            }
            $method = $this->cAction;
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                throw new Exception('Method not found');
            }
        } catch (Exception $e) {
            require APPLICATION_PATH . 'Errors/404.php';
        }
    }

    public function __construct()
    {
        $this->getRoutes();
        $this->setControllerName();
        $this->setControllerAction();
        $this->redirect();
    }
}
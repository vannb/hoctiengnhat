<?php

class Bootstrap {
    function __construct() {
        Session::init();
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = explode("/", trim($_GET['url'], '/'));
        } else {
            $url[0] = 'home';
        }
        $file = 'controllers/' . $url[0] . '.php';
        if (!file_exists($file)) {
            require 'controllers/error.php';
            new Error('This page does not exist');
            return;
        }
        require 'controllers/' . $url[0] . '.php';
        $controller = new $url[0];
        $controller->loadModel($url[0]);
        if (!isset($url[1])) {
            if (isset($_GET['method'])) {
                if(isset($_GET['param'])) {
                    $controller->$_GET['method']($_GET['param']);
                }
                $controller->$_GET['method']();
            }
            $controller->Index();
            return;
        }
        if (!method_exists($controller, $url[1])) {
            require 'controllers/error.php';
            new Error('Method does not exist');
            return;
        }
        if (!isset($url[2])) {
            $controller->$url[1]();
        } else
            $controller->$url[1]($url[2]);
        //$controller->Index();
    }
}

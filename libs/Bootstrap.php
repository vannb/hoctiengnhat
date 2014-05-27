<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
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
            View::render_error('Trang này không tồn tại');
            return;
        }
        require 'controllers/' . $url[0] . '.php';
        $controller = new $url[0];
        $controller->loadModel($url[0]);
        if (!isset($url[1])) {
            if (isset($_GET['method'])) {
                if (isset($_GET['param'])) {
                    $controller->$_GET['method']($_GET['param']);
                }
                $controller->$_GET['method']();
            }
            $controller->Index();
            return;
        }
        if (!method_exists($controller, $url[1])) {
            View::render_error('Không tìm thấy chức năng bạn yêu cầu');
            return;
        }
        if (!isset($url[2])) {
            $controller->$url[1]();
        } else
            $controller->$url[1]($url[2]);
        //$controller->Index();
    }

}

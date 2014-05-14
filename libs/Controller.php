<?php

class Controller {

    protected $name = '';
    protected $view;
    protected $model;
            function __construct($name) {
        @session_start();
        $this->name = $name;
        $this->view = new View($name);
    }

    public function loadModel() {
        $name = $this->name;
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require 'models/' . $name . '_model.php';
            $modelName = $name . '_Model';
            $this->model = new $modelName();
            $this->model->db->debug = DEBUG_MODE;
            $this->model->name = $name;
        }
    }

    public function error($error_code) {
        die('Xuất hiện lỗi: ' . $error_code);
    }

}

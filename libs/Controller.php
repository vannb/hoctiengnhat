<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
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

    public function error($message) {
        $this->view->render_error($message);
    }

}

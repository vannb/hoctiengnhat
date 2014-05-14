<?php
class Logout extends Controller{

    function __construct() {
        parent::__construct();
    }

    function index(){
        $this->view->render('logout/index');
    }
    function LogoutSubmit(){
        $this->model->LogoutSubmit();
        header('location: '.URL.'home');
        exit;
    }
}
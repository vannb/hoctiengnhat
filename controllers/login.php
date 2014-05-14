<?php

class Login extends Controller{

    function __construct() {
        parent::__construct('login');
    }
    
    function index(){
        $this->view->render('login/index');
    }
    
    function submit(){    
        $this->model->submit();
        header('location: '.URL.'home');
        exit;
    }
}
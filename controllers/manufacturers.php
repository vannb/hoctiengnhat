<?php

class Manufacturers extends Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['role'])|| !in_array($_SESSION['role'], array('Owner','Admin'))){
            require 'controllers/Error.php';
            new Error('ban khong co quyen');
            exit;
        }
    }

    function index() {
        $this->view->manufacturers = $this->model->search();
        $this->view->render('manufacturers/index');
    }

    function Add() {
        $this->view->render('manufacturers/edit');
        exit;
    }

    function Edit($manufacturerID){
        $this->view->manufacturer= $this->model->manufacturerByID($manufacturerID);
        $this->view->render('manufacturers/edit');
        exit;
    }
    
    function EditSubmit(){
        if ($_POST['manufacturerid'] == 0) {
            $result = $this->model->Add($_POST['manufacturername']);
        } else {
            $result = $this->model->Edit($_POST['manufacturerid'], $_POST['manufacturername']);
        }
        if ($result == 0) {
            require 'controllers/Error.php';
            new Error('Manufacturer already existed');
            exit;
        }
    }
    
    function Delete($manufacturerID){
        
    }
    function AddSubmit() {
        $result = $this->model->search($_POST['manufacturername']);
        if (empty($result)) {
            $this->model->Add($_POST['manufacturername']);
        } else {
            require 'controllers/Error.php';
            new Error('Manufacturer already existed');
            exit;
        }
    }

}

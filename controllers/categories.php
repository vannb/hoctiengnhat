<?php

class Categories extends Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], array('Owner', 'Admin'))) {
            require 'controllers/Error.php';
            new Error('ban khong co quyen');
            exit;
        }
    }

    function index() {
        $this->view->categories = $this->model->search();
        $this->view->render('categories/index');
    }

    function Add() {
        $this->view->render('categories/edit');
        exit;
    }

    function Edit($categoryID) {
        $this->view->category = $this->model->categoryByID($categoryID);
        $this->view->render('categories/edit');
        exit;
    }

    function EditSubmit() {
        if ($_POST['categoryid'] == 0) {
            $result = $this->model->Add($_POST['categoryname']);
        } else {
            $result = $this->model->Edit($_POST['categoryid'], $_POST['categoryname']);
        }
        if ($result == 0) {
            require 'controllers/Error.php';
            new Error('Category already existed');
            exit;
        }
    }
}

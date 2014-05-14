<?php

class Products extends Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], array('Owner', 'Admin'))) {
            require 'controllers/Error.php';
            new Error('ban khong co quyen');
            exit;
        }
    }

    function index() {
        if (!isset($_GET['limit']))
            $_GET['limit'] = 5;

        if (!isset($_GET['pricefrom']))
            $_GET['pricefrom'] = 0;

        if (!isset($_GET['priceto']))
            $_GET['priceto'] = 0;

        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }

        if (!isset($_GET['productname']))
            $_GET['productname'] = '';

        if (!isset($_GET['categoryid']))
            $_GET['categoryid'] = 0;

        if ($_GET['categoryid'] != 0)
            $this->view->category = $this->model->CategoryByID($_GET['categoryid']);

        if (!isset($_GET['manufacturerid']))
            $_GET['manufacturerid'] = 0;

        if ($_GET['manufacturerid'] != 0)
            $this->view->manufacturer = $this->model->ManufacturerByID($_GET['manufacturerid']);

        if (!isset($_GET['orderby']))
            $_GET['orderby'] = 0;

        $offset = ($_GET['page'] - 1) * $_GET['limit'];
        $this->view->numberOfProduct = $this->model->count($_GET['productname'],$_GET['pricefrom'],$_GET['priceto'],$_GET['categoryid'],$_GET['manufacturerid']);
        $this->view->pages = (int) ((($this->view->numberOfProduct) - 1) / $_GET['limit']) + 1;
        $this->view->products = $this->model->search(
                $_GET['productname']
                , $_GET['pricefrom']
                , $_GET['priceto']
                , $_GET['categoryid']
                , $_GET['manufacturerid']
                , $offset, $_GET['limit']
        );
        $this->view->render('products/index');
    }

    function search() {
        if (isset($_GET['keyword'])) {
            if (!isset($_GET['categoryid']))
                $_GET['categoryid'] = 0;
            if (!isset($_GET['firstlimit']))
                $_GET['firstlimit'] = 0;
            if (!isset($_GET['lastlimit']))
                $_GET['lastlimit'] = 5;
            $this->view->result = $this->model->search($_GET['keyword'], $_GET['categoryid'], $_GET['firstlimit'], $_GET['lastlimit']);
            $this->view->render('products/index');
            exit;
        }
    }

    function Add() {
        $this->view->manufacturers = $this->model->searchManufacturer();
        $this->view->categories = $this->model->searchCategories();
        $this->view->render('products/edit');
        exit;
    }

    function Edit($ProductID) {
        $this->view->product = $this->model->productByID($ProductID);
        $this->view->manufacturers = $this->model->searchManufacturer();
        $this->view->categories = $this->model->searchCategories();
        $this->view->render('products/edit');
        exit;
    }

    function EditSubmit() {
        if ($_POST['productid'] == 0) {
            unset($_POST['productid']);
            $result = $this->model->Add($_POST, $_FILES['images']);
        } else {
            $result = $this->model->Edit($_POST, $_FILES['images']);
        }
    }

    function DeleteMany() {
        $result = $this->model->DeleteMany($_POST['selected']);
    }

    function Delete($productID) {
        $result = $this->model->Delete($productID);
    }

    function DeletePicture() {
        $productID = $_GET['productid'];
        $image = $_GET['image'];
        $imagepath = 'views/images/products/' . $productID . '/' . $image;
        if (is_file($imagepath)) {
            unlink($imagepath);
        }
        header('location: ' . URL . 'Products/Edit/' . $productID);
        exit;
    }

}

<?php

class Orders extends Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['role'])|| !in_array($_SESSION['role'], array('Owner','Seller'))){
            require 'controllers/Error.php';
            new Error('ban khong co quyen');
            exit;
        }
    }

    function Index() {
        if (!isset($_GET['limit']))
            $_GET['limit'] = 5;
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $offset = ($_GET['page'] - 1) * $_GET['limit'];
        $this->view->numberOfOrder = $this->model->count();
        $this->view->pages = (int) ((($this->view->numberOfOrder) - 1) / $_GET['limit']) + 1;
        $this->view->orders = $this->model->search($offset, $_GET['limit']);
        $this->view->render('orders/index');
        exit;
    }

    function Mark() {
        foreach ($_POST['selected'] as $key => $value){
            $this->$_POST['action']($value);
        }
    }

    function Purchased($orderID) {
        $this->model->SetPurchased($orderID);
    }

    function NotPurchased($orderID) {
        $this->model->SetNotPurchased($orderID);
    }

    function Delivered($orderID) {
        $this->model->SetDelivered($orderID);
    }

    function NotDelivered($orderID) {
        $this->model->SetNotDelivered($orderID);
    }

    function Count() {
        return $this->model->count();
    }

}

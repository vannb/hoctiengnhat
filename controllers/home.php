<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author Loving
 */
class Home extends Controller {

    public function __construct() {
        parent::__construct('home');
        $this->view->template->navbar = array();
        $this->view->template->sidebar = array();
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = 'Trang chủ';
        $this->view->template->breadcrumbs = array('Trang chủ' => 'index.php');
    }

    function SearchProducts() {
        if (!isset($_GET['limit']))
            $_GET['limit'] = 4;

        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if (!isset($_GET['keyword']))
            $_GET['keyword'] = '';

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
        $this->view->numberOfProduct = $this->model->CountProduct($_GET['keyword'], $_GET['categoryid'], $_GET['manufacturerid']);
        $this->view->pages = (int) ((($this->view->numberOfProduct) - 1) / $_GET['limit']) + 1;
        $this->view->result = $this->model->searchProducts($_GET['keyword'], $_GET['categoryid'], $_GET['manufacturerid'], $offset, $_GET['limit'], $_GET['orderby']);
        $this->view->render('home/searchproduct');
        exit;
    }

    function Index() {
        $this->view->render_error('Bạn cùi vãi');
        $this->view->render('home/index');
    }

    function Cart() {
        if (isset($_SESSION['cart'])) {
            $this->view->cart = $_SESSION['cart'];
            foreach ($_SESSION['cart'] as $productID => $info) {
                if ($info['quantity'] > 0) {
                    $this->view->product[$productID] = $this->model->productByID($productID);
                }
            }
        } else
            $this->view->cart = array();
        $this->view->render('home/cart');
        exit;
    }

    function AddToCart() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            return;
        if ((int) $_POST['quantity'] <= 0) {
            require 'controllers/error.php';
            new Error('Please enter a positive number');
            exit;
        }
        $product = $this->model->productByID($_POST['productID']);
        if (empty($product))
            return;
        if (!isset($_SESSION['cart'][$_POST['productID']]['quantity'])) {
            $_SESSION['cart'][$_POST['productID']]['quantity'] = 0;
        }
        $_SESSION['cart'][$_POST['productID']]['price'] = $_POST['price'];
        $_SESSION['cart'][$_POST['productID']]['productname'] = $product['ProductName'];
        $_SESSION['cart'][$_POST['productID']]['quantity']+=$_POST['quantity'];
        header('location: ' . URL . 'home/cart');
        exit;
    }

    function RemoveFromCart() {
        unset($_SESSION['cart'][$_POST['productID']]);
        header('location: ' . URL . 'home/cart');
        exit;
    }

    function ConfirmOrder() {
        if (empty($_SESSION['cart']) || empty($_SESSION['order'])) {
            header('location: ' . URL);
            exit;
        }
        foreach ($_SESSION['cart'] as $productID => $info) {
            if ($info['quantity'] > 0) {
                $this->view->product[$productID] = $this->model->productByID($productID);
            }
        }
        $this->view->order = $_SESSION['order'];
        $this->view->cart = $_SESSION['cart'];
        $this->view->render('home/confirmorder');
        exit;
    }

    function ProcessOrder() {
        if (empty($_SESSION['cart']) || empty($_SESSION['order'])) {
            header('location: ' . URL);
            exit;
        }
        $orderinfo = $this->model->ProcessOrder($_SESSION['cart'], $_SESSION['order']);
        if ($orderinfo) {
            $_SESSION['orderid'] = $orderinfo[0];
            $_SESSION['orderdatetime'] = $orderinfo[1];
            header('location: ' . URL . 'home/success');
            exit;
        } else {
            require 'controllers/error.php';
            new Error('Error occur during transfer data to database');
            exit;
        }
    }

    function Order() {
        if (empty($_SESSION['cart'])) {
            header('location: ' . URL);
            exit;
        }
        $this->view->render('home/order');
        exit;
    }

    function ViewProduct($productID) {
        $this->view->product = $this->model->productByID($ProductID);
        $this->view->render('products/display');
        //var_dump($this->view->product);
        exit;
    }

    function Success() {
        try {
            if (isset($_SESSION['order'])) {
                $_SESSION['ordersuccess'] = $_SESSION['order'];
                $_SESSION['cartsuccess'] = $_SESSION['cart'];
                $_SESSION['totalsuccess'] = $_SESSION['total'];
                $_SESSION['orderidsuccess'] = $_SESSION['orderid'];
                $_SESSION['orderdatetimesuccess'] = $_SESSION['orderdatetime'];

                unset($_SESSION['order']);
                unset($_SESSION['cart']);
                unset($_SESSION['total']);
                unset($_SESSION['orderid']);
                unset($_SESSION['orderdatetime']);
            }
            $this->view->order = $_SESSION['ordersuccess'];
            $this->view->cart = $_SESSION['cartsuccess'];
            $this->view->total = $_SESSION['totalsuccess'];
            $this->view->orderid = $_SESSION['orderidsuccess'];
            $this->view->orderdatetime = $_SESSION['orderdatetimesuccess'];
            $this->view->render('home/success', 0);
        } catch (Exception $e) {
            
        }
        exit;
    }

    function DisplayProduct($ProductID) {
        $this->view->product = $this->model->productByID($ProductID);
        $this->view->render('home/displayproduct');
        //var_dump($this->view->product);
        exit;
    }

}

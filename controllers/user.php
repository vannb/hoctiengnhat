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
class User extends Controller {

    public function __construct() {
        parent::__construct('user');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = 'Đăng ký';
        $this->view->template->breadcrumbs = array(
            'Đăng ký' => null
        );
    }

    function Index() {
        $this->view->render('user/index');
    }

    function Login() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            session::destroy();
            session::init();
        }
        $this->view->render('user/login', '', 0);
        exit;
    }

    function Register() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $username = trim(get_post_var('username', null));
            $confirm_password = get_post_var('confirm_password', null);
            $name = trim(get_post_var('name', null));
            $password = get_post_var('password', null);
            $email = get_post_var('email', null);
            $policy = get_post_var('policy', null);
            
            $confirm_email = get_post_var('confirm_email', null);
            if (strlen($username) > 32 or strlen($username) < 5) {
                $this->view->render('user/register', 'Tên đăng nhập phải từ 5 đến 32 ký tự');
                exit;
            }

            if (strlen($username) > 32 or strlen($username) < 5) {
                $this->view->render('user/register', 'Mật khẩu phải từ 5 đến 32 ký tự');
                exit;
            }

            if ($confirm_password != $password) {
                $this->view->render('user/register', 'Nhập lại mật khẩu không khớp');
                exit;
            }

            if ($name == '') {
                $this->view->render('user/register', 'Tên không được trống');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view->render('user/register', 'Email không hợp lệ');
                exit;
            }
            if ($confirm_email != $email) {
                $this->view->render('user/register', 'Nhập lại Email không khớp');
                exit;
            }
            if ($policy != 'agree') {
                $this->view->render('user/register', 'Bạn phải đồng ý với các điều khoản');
                exit;
            }
            $this->model->register();
        }
        $this->view->render('user/register');
        exit;
    }

    function check_availability() {
        $result = $this->model->check_availability($_POST['username']);
        $json = json_encode(array('available' => 'true'));
        echo $json;
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

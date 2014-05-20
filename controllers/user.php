<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
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
        $this->view->template->title = translate('Đăng ký');
        $this->view->template->header = translate('Đăng ký');
        $this->view->template->breadcrumbs = array(
            translate('Đăng ký') => null
        );
    }

    function Index() {
        echo translate('chưa viết hàm index');
    }

    function Login() {
        $this->view->template->title = translate('Đăng nhập');
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $message = get_post_var('popup_msg');
            if ($message) {
                $this->view->render('user/login', $message, 0);
                exit;
            }
            $username = trim(get_post_var('username', ''));
            $password = trim(get_post_var('password', ''));

            if (strlen($username) > 32 or strlen($username) < 5) {
                $this->view->render('user/login', translate('Tên đăng nhập phải từ 5 đến 32 ký tự'), 0);
                exit;
            }

            session::destroy();
            session::init();
            session_regenerate_id(true);
            $result = $this->model->login();
            if ($result === true) {
                header('location: ' . URL);
                exit;
            } else {
                //dang nhap lai
                $this->view->render('user/login', $result, 0);
                exit;
            }
        }
        $this->view->render('user/login', '', 0);
        exit;
    }

    public function logout() {
        session::destroy();
        session::init();
        session_regenerate_id(true);
        header('location: '.URL.'user/login');
    }

    function Register() {
        $this->view->template->title = translate('Đăng ký');

        if ($_SERVER['REQUEST_METHOD'] == "POST") {//submit xong thi lam gi
            $username = trim(get_post_var('username', ''));
            $confirm_password = trim(get_post_var('confirm_password', ''));
            $name = trim(get_post_var('name', ''));
            $password = trim(get_post_var('password', ''));
            $email = trim(get_post_var('email', ''));
            $policy = get_post_var('policy', '');

            $confirm_email = get_post_var('confirm_email', null);
            if (strlen($username) > 32 or strlen($username) < 5) {
                $this->view->render('user/register', translate('Tên đăng nhập phải từ 5 đến 32 ký tự'));
                exit;
            }

            if ($confirm_password != $password) {
                $this->view->render('user/register', translate('Nhập lại mật khẩu không khớp'));
                exit;
            }

            if ($name == '') {
                $this->view->render('user/register', translate('Tên không được trống'));
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view->render('user/register', translate('Email không hợp lệ'));
                exit;
            }
            if ($confirm_email != $email) {
                $this->view->render('user/register', translate('Nhập lại Email không khớp'));
                exit;
            }
            if ($policy != 'agree') {
                $this->view->render('user/register', translate('Bạn phải đồng ý với các điều khoản'));
                exit;
            }
            //sau khi cac thong tin hop le, add user
            $result = $this->model->register();
            if ($result === true) {
                about_user::require_login(translate('Đăng ký thành công, xin vui lòng đăng nhập'));
                exit;
            } else {
                //render lai register voi thong bao loi $result
                $this->view->render('user/register', $result);
                exit;
            }
        }
        //load trang thi lam gi
        $this->view->render('user/register');
        exit;
    }

    function check_availability() {
        $result = $this->model->check_availability($_POST['username']);
        $json = json_encode(array('available' => 'true'));
        echo $json;
    }

    function forgotPassword() {
        
    }

}

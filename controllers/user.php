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
            $result = $this->model->register();
            if ($result === 1) {
                about_user::require_login('Đăng ký thành công, xin vui lòng đăng nhập');
                $this->view->render('user/login', 'Đăng ký thành công, xin vui lòng đăng nhập');
                exit;
            } else {
                $this->view->render('user/register', $result);
            }
        }
        $this->view->render('user/register');
        exit;
    }

    function check_availability() {
        $result = $this->model->check_availability($_POST['username']);
        $json = json_encode(array('available' => 'true'));
        echo $json;
    }

}

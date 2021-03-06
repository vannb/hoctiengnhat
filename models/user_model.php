<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class User_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function login() {
        $username = strtolower(trim(get_post_var('username')));
        $password = trim(get_post_var('password', ''));

        $user = new about_user(null, $username);
        
        if ($user->user_id == null) {
            return translate("Tài khoản không tồn tại");
            exit();
        }
        if (!PasswordHash::Check($password, $user->password)) {
            return translate('Mật khẩu không chính xác');
            exit();
        }
        
        @session::init();
        Session::set('user', $user);
        return true;
    }

    function register() {
        $username = strtolower(trim(get_post_var('username')));
        $password = PasswordHash::Hash(get_post_var('password'));
        $name = trim(get_post_var('name'));
        $email = strtolower(trim(get_post_var('email')));

        $result = $this->check_availability($username, $email);
        if ($result == 'email') {
            return translate('Địa chỉ email đã tồn tại');
        }

        if ($result == 'username') {
            return translate('Tên đăng nhập đã tồn tại');
        }

        $arr_data = array(
            'C_USERNAME' => $username,
            'C_PASSWORD' => $password,
            'C_NAME' => $name,
            'C_EMAIL' => $email
        );
        $result = DB::insert('t_user', $arr_data);
        if (!$result) {
            return translate('Lỗi không xác định, xin vui lòng thử lại');
        }
        return true;
    }

    function check_availability($username = null, $email = null) {
        if ($username) {
            $result = DB::count('t_user', array(), array('C_USERNAME' => $username));
            if ($result) {
                return 'username';
            }
        }
        if ($email) {
            $result = DB::count('t_user', array(), array('C_EMAIL' => $email));
            if ($result) {
                return 'email';
            }
        }
        return 'available';
    }

}

?>
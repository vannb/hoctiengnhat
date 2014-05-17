<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class about_user {
    
    public $username;
    public $password;
    public $user_id;
    public $name;
    public $is_admin;
    public $email;
    protected static $_mapping = array(
        'username' => 'C_USERNAME',
        'password' => 'C_PASSWORD',
        'user_id' => 'PK_USER',
        'is_admin' => 'C_IS_ADMIN',
        'email' => "C_EMAIL",
        'name' => 'C_NAME'
    );

    /**
     * Trả về thông tin người dùng đang đăng nhập
     * @return \ehr_user
     */
    public function import_array($arr_data) {
        if (empty($arr_data) || is_array($arr_data) == false) {
            return;
        }

        $mapping = static::$_mapping;
        foreach ($mapping as $prop => $col) {
            $this->{$prop} = isset($arr_data[$col]) ? $arr_data[$col] : null;
        }

        foreach ($mapping as $prop => $col) {
            $this->{$prop} = isset($arr_data[$col]) ? $arr_data[$col] : null;
        }
    }

    public static function current_user() {
        Session::init();
        return Session::get('user');
    }

    public static function is_login() {
        return ((bool) self::current_user());
    }

    public static function require_login($message = null) {
        if (!self::is_login()) {
            if(is_null($message)) $message = translate("Bạn phải đăng nhập để có thể thực hiện chức năng này");
            if ($message) {
                redirect_popup_msg(URL . 'user/login', $message);
            }
            header('Location: ' . URL . 'user/login');
            exit;
        }
    }

    public function __construct($user_id = null, $username = null) {
        if ($user_id) {
            $this->import_array(
                    self::qry_single_user_by_id($user_id)
            );
        } elseif ($username) {
            $this->import_array(
                    self::qry_single_user_by_login($username)
            );
        }
    }

    static function qry_user_by_id($id, $fields = '*') {
        $sql = "Select $fields From t_user Where PK_USER = ?";
        $params = array($id);
        return DB::get_instance()->GetRow($sql, $params);
    }

    static function qry_user_by_username($username, $fields = '*') {
        $sql = "Select $fields From t_user Where C_USERNAME = ?";
        $params = array($username);
        return DB::get_instance()->GetRow($sql, $params);
    }

    static function qry_all_user($fields = '*', $assoc = false) {
        $sql = "Select $fields From t_user";
        if ($assoc) {
            return DB::get_instance()->GetAssoc($sql);
        } else {
            return DB::get_instance()->GetAll($sql);
        }
    }

    public function is_admin() {
        return ((bool) $this->is_admin);
    }
}

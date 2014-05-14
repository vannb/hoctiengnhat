<?php

class Login_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function submit() {
        $username = $_POST['username'];
        $password = $_POST['pass'];
        $result = $this->db->search('users',0,array('username' => $username,'pass' => $password),0,0,0);
        if (!empty($result)) {
            Session::set('loggedIn', true);
            Session::set('role', $result[0]['Role']);
        } else {
            require 'controllers/error.php';
            new Error('Incorrect id or password');
            exit;
        }
    }
}

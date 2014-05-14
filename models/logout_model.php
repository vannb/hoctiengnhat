<?php

class Logout_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function LogoutSubmit() {
        session_destroy();
    }

}

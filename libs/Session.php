<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Session {

    public static function init() {
        session_start();
    }

    public static function get($key) {
        self::init();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }

    public static function destroy() {
        session_destroy();
    }

}

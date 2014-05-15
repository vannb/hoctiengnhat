<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Cookie {

    /**
     * @param string $name
     * @param mixed $value
     * @param type $hours
     */
    static function set($name, $value, $hours = null) {
        if ($hours == null) {
            $hours = 10;
        }
        setcookie($name, $value, time() + $hours * 3600, PATH);
    }

    /**
     * 
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    static function get($name, $default = null, $escape = true) {
        $var = isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
        if (!$escape) {
            return $var;
        }
        if (!is_array($var)) {
            return ($var);
        } else {
            array_walk_recursive($var, 'escape_string');
            return $var;
        }
    }

    static function unset_var($name) {
        setcookie($name, null, time() - 10, SITE_ROOT);
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
        }
    }

}

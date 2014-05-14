<?php
ini_set('date.timezone', 'Asia/Ho_Chi_Minh');

define('SERVER_ROOT', __DIR__ . '/');
require_once (SERVER_ROOT . 'libs/session.php');

require 'config/config.php';

if (DEBUG_MODE > 0)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
else
{
    error_reporting(0);
    ini_set('display_errors', 0);
}

require_once (SERVER_ROOT . 'libs/Bootstrap.php');
require_once (SERVER_ROOT . 'libs/Controller.php');
require_once (SERVER_ROOT . 'libs/Model.php');
require_once (SERVER_ROOT . 'libs/Session.php');
require_once (SERVER_ROOT . 'libs/SharedFunctions.php');
require_once (SERVER_ROOT . 'libs/PasswordHash.php');
require_once (SERVER_ROOT . 'libs/Session.php');
require_once (SERVER_ROOT . 'libs/Cookie.php');
require_once (SERVER_ROOT . 'libs/View.php');
require_once (SERVER_ROOT . 'libs/DB.php');

$app = new Bootstrap();
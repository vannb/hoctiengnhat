<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
header('Content-type: application/json');
require 'libs/DB.php';
DB::get_instance();
$json = json_encode(array('available' => 'true'));
echo $json;
?>

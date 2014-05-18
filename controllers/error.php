<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

require 'libs/Controller.php';

class Error extends Controller {

    function __construct($msg = null, $mode = 0) {
        if(is_null($msg)){
            $msg = translate('Lỗi không xác định');
        }
        parent::__construct('error');
        $this->index($msg, $mode);
    }

    function index($msg = '', $mode = 0) {
        $this->view->msg = $msg;
        $this->view->render('error/index', '', $mode);
    }

}

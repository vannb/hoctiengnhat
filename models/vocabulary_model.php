<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class vocabulary_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    function qry_all_vocabulary_by_lesson($lesson_id){
        $result = DB::search('t_vocabulary',array(),array('FK_LESSON'=>$lesson_id));
        return $result;
    }
}
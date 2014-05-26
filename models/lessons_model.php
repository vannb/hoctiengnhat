<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class lessons_model extends Model {

    function __construct() {
        parent::__construct();
    }

    function qry_all_lessons_by_course($course_id) {

       // $user_id = about_user::current_user()->user_id;
        $db = DB::get_instance();
        $sql = "SELECT * FROM t_lesson WHERE FK_COURSE = ?";
        
        $result = $db->GetAll($sql,array($course_id,false));
        return $result;
    }

   
}

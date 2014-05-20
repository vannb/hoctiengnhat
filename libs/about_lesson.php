<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class about_lesson {

    public function __construct() {
        
    }

    public static function qry_lesson_name($lesson_id) {
        $result = DB::search('t_lesson', array(), array('PK_LESSON' => $lesson_id));
        return $result[0]['C_NAME'];
    }

    public static function qry_course_by_lesson_id($lesson_id) {
        $result = DB::search(
                        't_lesson le join t_course co on le.FK_COURSE = co.PK_COURSE'
                        , array()
                        , array('PK_LESSON' => $lesson_id)
                        , 0//offset
                        , 0//limit
                        , 0//orderby
                        , 'PK_COURSE, co.C_NAME'//rows
        );
        return $result[0];
    }

}

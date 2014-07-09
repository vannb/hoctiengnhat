<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class about_lesson {

    public function __construct() {
        
    }

    public static function qry_lesson_name($lesson_id) {
        $result = DB::search('t_lesson', array(), array('PK_LESSON' => $lesson_id));
        return $result[0]['C_NAME'];
    }

    public static function qry_course_name($course_id) {
        $result = DB::search('t_course', array(), array('PK_COURSE' => $course_id));
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
                        , 'PK_COURSE, co.C_NAME'
        );
        return $result[0];
    }

    public static function qry_all_level() {
        $result = DB::search('t_level');
        return $result;
    }

    public static function qry_course_lesson($course_id) {
        $result = DB::search('t_lesson', array(), array('FK_COURSE' => $course_id));
        return $result;
    }
    public static function qry_course_kanji_lesson($course_id) {
        $db = DB::get_instance();
        return $db->GetAll('SELECT *, PK_KANJI_LESSON AS PK_LESSON FROM t_kanji_lesson WHERE FK_COURSE = ?',array($course_id));
    }

    public static function qry_level_course($level_id) {
        $result = DB::search('t_course', array(), array('FK_LEVEL' => $level_id));
        return $result;
    }

}

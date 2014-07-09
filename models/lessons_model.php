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

        $result = $db->GetAll($sql, array($course_id, false));
        return $result;
    }

    function has_vocab($lesson_id) {
        return DB::count('t_vocabulary', array(), array('FK_LESSON' => $lesson_id)) > 0;
    }

    function has_grammar($lesson_id) {
        return DB::count('t_grammar', array(), array('FK_LESSON' => $lesson_id)) > 0;
    }

    function has_exam($lesson_id) {
        $db = DB::get_instance();
        return $db->GetOne("SELECT COUNT(*) FROM t_exam ex JOIN t_question q"
                        . " ON ex.PK_EXAM = q.FK_EXAM"
                        . " AND ex.FK_LESSON = ?", array($lesson_id)) ||
                $db->GetOne("SELECT COUNT(*) FROM t_exam ex JOIN t_reading re"
                        . " ON ex.PK_EXAM = re.FK_EXAM JOIN t_question q"
                        . " ON re.PK_READING = q.FK_READING"
                        . " AND ex.FK_LESSON = ?", array($lesson_id));
    }

}

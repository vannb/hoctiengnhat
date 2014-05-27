<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Exam_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function qry_course_exam($course_id) {
        return DB::search(
                        'SELECT * FROM t_lesson le JOIN t_exam ex'
                        . ' ON ex.FK_LESSON = le.PK_LESSON'
                        , array(), array('FK_COURSE' => $course_id)
        );
    }

    function qry_exam_by_lesson($lesson_id) {
        $result = DB::search('t_exam', array(), array('FK_LESSON' => $lesson_id));
        return $result[0];
    }

    function qry_exam_vocab_question($exam_id) {
        return DB::search('t_question',array(),array('FK_EXAM' => $exam_id,'FK_READING >' => 0),0,10,'RAND()');
    }

}

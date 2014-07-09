<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Exam_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function qry_course_exam($course_id)
    {
        return DB::search(
                        'SELECT * FROM t_lesson le JOIN t_exam ex'
                        . ' ON ex.FK_LESSON = le.PK_LESSON'
                        , array(), array('FK_COURSE' => $course_id)
        );
    }

    function qry_reading($reading_id)
    {
        $result = DB::search('t_reading', array(), array('PK_READING' => $reading_id), 0, 1);
        return empty($result) ? array() : $result[0];
    }

    function qry_exam_by_lesson($lesson_id)
    {
        $result = DB::search('t_exam', array(), array('FK_LESSON' => $lesson_id));
        return empty($result) ? array() : $result[0];
    }

    function qry_question($question_id)
    {
        $result = DB::search('t_question', array(), array('PK_QUESTION' => $question_id));
        return empty($result) ? array() : $result[0];
    }

    function qry_exam_multi_choices_question($exam_id)
    {
        return DB::search('t_question', array(), array('FK_EXAM' => $exam_id, 'FK_READING' => 0), 0, 10, 'RAND()');
    }

    function qry_exam_reading($exam_id)
    {
        $reading_result = DB::search('t_reading', array(), array('FK_EXAM' => $exam_id), 0, 1, 'RAND()');
        if (empty($reading_result))
            return array();
        $reading_result = $reading_result[0];
        return $reading_result;
    }

    function qry_reading_question($reading_id)
    {
        $arr_question = DB::search('t_question', array(), array('FK_READING' => $reading_id), 0, 2, 'RAND()');
        return $arr_question;
    }

    function save_point($exam_id, $point, $remain)
    {
        $db = DB::get_instance();
        $time = 15 * 60 - $remain;
        $db->Execute('INSERT INTO t_exam_point(FK_EXAM,FK_USER,C_POINT,C_SUBMIT_TIME,C_TIME)'
                . ' VALUES(?,?,?,NOW(),?)', array(
            $exam_id
            , about_user::current_user()->user_id
            , $point
            , $time
        ));
    }

    function qry_rank($exam_id, $point, $remain)
    {
        $time = 15 * 60 - $remain;
        $db = DB::get_instance();
        return $db->GetOne('SELECT COUNT(*) FROM t_exam_point'
                . ' WHERE FK_EXAM = ? AND C_POINT >= ?'
                . ' AND C_TIME < ? AND FK_USER != ?'
                , array(
            $exam_id
            , $point
            , $time
            , about_user::current_user()->user_id
        )) + 1;
        //return DB::count('t_exam_point', array(), array('FK_EXAM' => $exam_id, 'C_POINT>=' => $point, 'C_TIME<' => $time)) + 1;
    }

    function qry_all_rank($exam_id)
    {
        return DB::search('t_exam_point po join t_user us ON po.FK_USER = us.PK_USER', array(), array('FK_EXAM' => $exam_id), 0, 0, 'C_POINT DESC, C_TIME DESC');
    }

}

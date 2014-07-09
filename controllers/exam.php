<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class exam extends Controller
{
    function __construct()
    {
        parent::__construct('exam');
        $this->view->template->show_sidebar = 0;
        $this->view->template->show_toggle_sidebar = 0;
    }

    function dsp_exam_result($lesson_id)
    {
        about_user::require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            View::render_error();
        }
        $exam_code = get_post_var('exam_code', '');
        $remain = get_post_var('remain', '');
        if ($exam_code == '' or Session::get('exam_code') == $exam_code)
        {
            exit;
        }
        Session::set('exam_code', $exam_code);

        $this->view->dsp_mode = 'result';
        $this->view->template->title = translate('Kết quả');
        $this->view->template->header = translate('Kết quả');

        $this->view->lesson_id = $lesson_id;
        $v_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $v_exam_info = $this->model->qry_exam_by_lesson($lesson_id);

        $reading_id = get_post_var('reading_id', 0);
        if ($reading_id !== 0)
        {
            $this->view->arr_reading = $this->model->qry_reading($reading_id);
        }
        $correct = 0;
        $number_of_questions = 0;
        foreach ($_POST as $key => $value)
        {
            if (startsWith($key, 'answer_multi_choices'))
            {
                $question_id = substr($key, 21);
                $question_info = $this->model->qry_question($question_id);
                if (!empty($question_info))
                {
                    $question_info['ANSWERED'] = $value;
                    $this->view->arr_multi_choices_question[] = $question_info;
                    $number_of_questions ++;
                    if ($question_info['ANSWERED'] == $question_info['C_CORRECT'])
                    {
                        $correct++;
                    }
                }
            } else if (startsWith($key, 'answer_reading'))
            {
                $question_id = substr($key, 15);
                $question_info = $this->model->qry_question($question_id);
                if (!empty($question_info))
                {
                    $question_info['ANSWERED'] = $value;
                    $this->view->arr_reading['question'][] = $question_info;
                    $number_of_questions ++;
                    if ($question_info['ANSWERED'] == $question_info['C_CORRECT'])
                    {
                        $correct++;
                    }
                }
            }
        }
        $this->view->point = $correct / $number_of_questions * 10;
        $this->model->save_point($v_exam_info['PK_EXAM'], $this->view->point, $remain);
        $this->view->rank = $this->model->qry_rank($v_exam_info['PK_EXAM'], $this->view->point, $remain);
        $this->view->template->breadcrumbs = array(
            translate("Kiểm tra") => $this->view->get_controller_url(),
            $v_course_info['C_NAME'] => $this->view->get_controller_url(),
            $v_exam_info['C_NAME'] => $this->view->get_controller_url() . 'dsp_lesson_exam/' . $lesson_id,
            translate('Kết quả') => null
        );
        $this->view->render('exam/dsp_lesson_exam');
    }

    function dsp_rank($lesson_id)
    {
        about_user::require_login();
        $this->view->template->title = translate('Kiểm tra');
        $this->view->template->header = translate('Kiểm tra');
        $this->view->lesson_id = $lesson_id;
        $v_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $this->view->lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $v_exam_info = $this->model->qry_exam_by_lesson($lesson_id);
        $this->view->template->breadcrumbs = array(
            $v_course_info['C_NAME'] => $this->view->get_controller_url('lessons') . 'dsp_course_lesson/' . $v_course_info['PK_COURSE'],
            $this->view->lesson_name => $this->view->get_controller_url('lessons') . 'dsp_single_lesson/' . $lesson_id,
            translate("Kiểm tra") => $this->view->get_controller_url('exam') . 'dsp_lesson_exam/' . $lesson_id,
            translate("Xếp hạng") => null
        );
        $this->view->arr_all_rank = $this->model->qry_all_rank($v_exam_info['PK_EXAM']);
        $this->view->render('exam/dsp_rank');
    }

    function dsp_lesson_exam($lesson_id)
    {
        about_user::require_login();
        $this->view->dsp_mode = 'exam';
        $this->view->template->title = translate('Kiểm tra');
        $this->view->template->header = translate('Kiểm tra');
        $this->view->lesson_id = $lesson_id;
        $v_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $this->view->lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $v_exam_info = $this->model->qry_exam_by_lesson($lesson_id);
        $this->view->arr_multi_choices_question = $this->model->qry_exam_multi_choices_question($v_exam_info['PK_EXAM']);
        $this->view->arr_reading = $this->model->qry_exam_reading($v_exam_info['PK_EXAM']);
        $this->view->arr_reading['question'] = $this->model->qry_reading_question($this->view->arr_reading['PK_READING']);
        $this->view->template->breadcrumbs = array(
            $v_course_info['C_NAME'] => $this->view->get_controller_url('lessons') . 'dsp_course_lesson/' . $v_course_info['PK_COURSE'],
            $this->view->lesson_name => $this->view->get_controller_url('lessons') . 'dsp_single_lesson/' . $lesson_id,
            translate("Kiểm tra") => null,
        );
        $this->view->render('exam/dsp_lesson_exam');
    }
}

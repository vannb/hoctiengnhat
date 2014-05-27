<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class exam extends Controller {

    function __construct() {
        parent::__construct('exam');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
    }

    function index() {
        $this->dsp_course_exam(1);
    }

    function dsp_course_exam($course_id) {
        $this->view->template->title = translate('Kiểm tra');
        $this->view->template->header = translate('Kiểm tra');
        //$this->view->arr_exam = $this->model->qry_course_exam($course_id);
        $this->view->template->breadcrumbs = array(
            translate("Kiểm tra") => $this->view->get_controller_url()
        );
        $this->view->render('exam/dsp_course_exam');
    }

    function dsp_lesson_exam($lesson_id) {
        $this->view->template->title = translate('Kiểm tra');
        $this->view->template->header = translate('Kiểm tra');
        $v_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $v_exam_info = $this->model->qry_exam_by_lesson($lesson_id);
        $this->view->arr_vocab_question = $this->model->qry_exam_vocab_question($v_exam_info['PK_EXAM']);
        $this->view->template->breadcrumbs = array(
            translate("Kiểm tra") => $this->view->get_controller_url(),
            $v_course_info['C_NAME'] => $this->view->get_controller_url(),
            $v_exam_info['C_NAME'] => null
        );
        $this->view->render('exam/dsp_lesson_exam');
    }

}

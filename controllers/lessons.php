<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class Lessons extends Controller
{

    public function __construct()
    {
        parent::__construct('lessons');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = translate('Học theo bài');
    }

    function dsp_course_lesson($course_id)
    {
        $this->view->template->title = $this->view->course_name;
        $this->view->course_name = about_lesson::qry_course_name($course_id);
        $this->view->arr_lesson = about_lesson::qry_course_lesson($course_id);
        $this->view->template->breadcrumbs = array(
            $this->view->course_name => null
        );
        $this->view->render('lessons/dsp_course_lesson');
    }

    function dsp_single_lesson($lesson_id)
    {
        //hiển thị các chức năng của từng bài (từ mới, ngữ pháp, test)
        $this->view->lesson_id = $lesson_id;
        $this->view->has_vocab = $this->model->has_vocab($lesson_id);
        $this->view->has_grammar = $this->model->has_grammar($lesson_id);
        $this->view->has_exam = $this->model->has_exam($lesson_id);

        $this->view->lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $course = about_lesson::qry_course_by_lesson_id($lesson_id);
        $this->view->template->title = $this->view->lesson_name;
        $this->view->template->breadcrumbs = array(
            $course['C_NAME'] => $this->view->get_controller_url() . 'dsp_course_lesson/' . $course['PK_COURSE'],
            $this->view->lesson_name => null
        );

        $this->view->render('lessons/dsp_single_lesson');
    }

}

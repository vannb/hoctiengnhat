<?php
class kanji extends Controller {
    public function __construct() {
        parent::__construct('kanji');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
    }
    
    public function xhr_toggle_star() {
        if (!about_user::is_login()) {
            echo '-1';
        } else {
            echo $this->model->toggle_star();
        }
    }
    function dsp_starred_kanji(){
        about_user::require_login();
        $this->view->lesson_name = translate('Được đánh dấu');
        $this->view->template->header = translate('Chữ Hán');
        $this->view->template->title = translate('Chữ Hán');
        $this->view->template->breadcrumbs = array(
            translate('Chữ Hán') => null,
            $this->view->lesson_name => $this->view->get_controller_url() . 'dsp_starred_kanji',
        );

        $this->view->arr_kanji = $this->model->qry_all_starred_kanji();
        $this->view->render('kanji/dsp_lesson_kanji');
    }
    function dsp_course_kanji_lesson($course_id) {
        $this->view->course_name = about_lesson::qry_course_name($course_id);
        $this->view->arr_lesson = about_lesson::qry_course_kanji_lesson($course_id);
        $this->view->template->breadcrumbs[translate("Chữ Hán")] = null;
        $this->view->template->breadcrumbs[$this->view->course_name] = null;
        $this->view->render('lessons/dsp_course_lesson');
    }
    function dsp_single_lesson($lesson_id) {
        
        $this->view->lesson_name = about_lesson::qry_kanji_lesson_name($lesson_id);
        $v_course = about_lesson::qry_course_by_kanji_lesson_id($lesson_id);
        $this->view->template->header = translate('Chữ Hán');
        $this->view->template->title = $this->view->lesson_name;
        
        $this->view->template->breadcrumbs = array(
            translate('Chữ Hán') => null,
            $v_course['C_NAME'] => $this->view->get_controller_url('kanji').'dsp_course_kanji_lesson/'.$v_course['PK_COURSE'],
            $this->view->lesson_name => $this->view->get_controller_url('kanji').'dsp_single_lesson/'.$lesson_id
        );
        
        $this->view->arr_kanji = $this->model->qry_lesson_kanji($lesson_id);
        $this->view->render('kanji/dsp_lesson_kanji');
    }
}

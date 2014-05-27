<?php

/**
 * Description of kanji
 *
 * @author Mons
 */
class kanji extends Controller {
    public function __construct() {
        parent::__construct('kanji');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
    }
    
    public function dsp_lesson_kanji($lesson_id) {
        
        $this->view->template->header = translate('Chữ Hán');
        $this->view->template->title = translate('Chữ Hán');
        
        $v_course = about_lesson::qry_course_by_lesson_id($lesson_id);
        $v_lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $this->view->template->breadcrumbs = array(
            $v_course['C_NAME'] => $this->view->get_controller_url('lesson').'dsp_course_lesson/'.$v_course['PK_COURSE'],
            $v_lesson_name => $this->view->get_controller_url('lesson').'dsp_single_lesson/'.$lesson_id,
            translate('Chữ Hán') => null
        );
        
        $this->view->arr_kanji = $this->model->qry_all_kanji_by_lesson($lesson_id);
        $this->view->render('kanji/dsp_lesson_kanji');
    }
    
    public function dsp_single_kanji($kanji_id) {
        
    }
}

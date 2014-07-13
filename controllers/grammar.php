<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class grammar extends Controller{

    function __construct() {
        parent::__construct('grammar');
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
    
    function dsp_starred_grammar(){
        about_user::require_login();
        $this->view->v_lesson_name = translate('Được đánh dấu');
        $this->view->template->header = translate('Ngữ pháp');
        $this->view->template->title = translate('Ngữ pháp').' - '.$this->view->v_lesson_name;
        $this->view->template->breadcrumbs = array(
            translate('Ngữ pháp') => null,
            $this->view->v_lesson_name => $this->view->get_controller_url() . 'dsp_starred_grammar',
        );

        $this->view->arr_grammar = $this->model->qry_all_starred_grammar();
        $this->view->render('grammar/dsp_lesson_grammar');
    }
    
    public function dsp_lesson_grammar($lesson_id){
        $this->view->arr_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $this->view->v_lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $this->view->template->title = $this->view->v_lesson_name.': '.translate('Ngữ pháp');
        $this->view->template->header = translate('Ngữ pháp');
        $this->view->template->breadcrumbs = array(
            $this->view->arr_course_info['C_NAME'] => $this->view->get_controller_url('lessons').'dsp_course_lesson/'.$this->view->arr_course_info['PK_COURSE'],
            $this->view->v_lesson_name => $this->view->get_controller_url('lessons').'dsp_single_lesson/'.$lesson_id,
            translate('Ngữ pháp') => null
        );
        $this->view->arr_grammar = $this->model->qry_lesson_grammar($lesson_id);
        $this->view->render('grammar/dsp_lesson_grammar');
    }
}
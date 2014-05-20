<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Loving
 */
class vocabulary extends Controller {

    public function __construct() {
        parent::__construct('vocabulary');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
    }

    public function dsp_lesson_vocabulary($lesson_id) {
        $this->view->template->header = translate('Từ vựng');
        $this->view->template->title = translate('Từ vựng');
        $arr_vocab = $this->model->qry_all_vocabulary_by_lesson($lesson_id);
        require 'libs/about_lesson.php';
        $v_course = about_lesson::qry_course_by_lesson_id($lesson_id);
        $v_lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $this->view->template->breadcrumbs = array(
            $v_course['C_NAME'] => $this->view->get_controller_url('lesson').'dsp_course_lesson/'.$v_course['PK_COURSE'],
            $v_lesson_name => $this->view->get_controller_url('lesson').'dsp_single_lesson/'.$lesson_id,
            translate('Từ vựng') => null
        );
        $this->view->render('vocabulary/dsp_lesson_vocabulary');
    }

}

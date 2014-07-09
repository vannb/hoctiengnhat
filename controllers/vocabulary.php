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
        $this->view->template->show_sidebar = 0;
        $this->view->template->show_toggle_sidebar = 0;
    }

    public function dsp_lesson_vocabulary($lesson_id) {
        $this->view->arr_course_info = about_lesson::qry_course_by_lesson_id($lesson_id);
        $this->view->v_lesson_name = about_lesson::qry_lesson_name($lesson_id);
        $this->view->template->header = translate('Từ vựng');
        $this->view->template->title = translate('Từ vựng');
        $this->view->template->breadcrumbs = array(
            $this->view->arr_course_info['C_NAME']
            => $this->view->get_controller_url('lessons') . 'dsp_course_lesson/' . $this->view->arr_course_info['PK_COURSE'],
            $this->view->v_lesson_name => $this->view->get_controller_url('lessons') . 'dsp_single_lesson/' . $lesson_id,
            translate('Từ vựng') => null
        );

        $this->view->arr_vocab = $this->model->qry_lesson_vocabulary($lesson_id);
        $this->view->render('vocabulary/dsp_vocabulary');
    }

    public function dsp_starred_vocabulary() {
        about_user::require_login();
        $this->view->v_lesson_name = 'Được đánh dấu';
        $this->view->template->header = translate('Từ vựng');
        $this->view->template->title = translate('Từ vựng');
        $this->view->template->breadcrumbs = array(
            translate('Từ vựng') => null,
            $this->view->v_lesson_name => $this->view->get_controller_url() . 'dsp_starred_vocabulary',
        );

        $this->view->arr_vocab = $this->model->qry_all_starred_vocabulary();
        $this->view->render('vocabulary/dsp_vocabulary');
    }

    public function xhr_toggle_star() {
        if (!about_user::is_login()) {
            echo '-1';
        } else {
            echo $this->model->toggle_star();
        }
    }

}

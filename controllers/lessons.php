<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author VanNB
 */
class Lessons extends Controller {

    public function __construct() {
        parent::__construct('lessons');
        //$this->view->template->navbar = array('1' => array('1' => array('1'=>'1')));
        //$this->view->template->sidebar = array();
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = 'Trang chủ';
        $this->view->template->title = 'Trang chủ';
        $this->view->template->breadcrumbs = array(translate('Trang chủ') => 'index.php');
    }

    function Index() {
        $this->view->render('lessons/index');
    }

    function dsp_course_lesson($course_id) {
        //: hiển thị danh sách tất cả các bài theo khóa (khóa ở đây là Trung cấp, Sơ cấp...)
        $this->view->lessonList = $this->model->qry_all_lessons_by_course($course_id);
        $this->view->render('lessons/dsp_course_lesson');
    }

    function dsp_single_lesson($lesson_id) {
        //hiển thị các chức năng của từng bài (từ mới, ngữ pháp, test)
        $this->view->lesson_id = $lesson_id;
        $this->view->render('lessons/dsp_single_lesson');
    }

}

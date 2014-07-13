<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Qna extends Controller
{

    public function __construct()
    {
        parent::__construct('qna');
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = translate('Hỏi đáp');
        $this->view->template->title = translate('Hỏi đáp');
        $this->view->template->breadcrumbs = array(translate('Hỏi đáp') => null);
    }
    
    function index(){
        $this->dsp_all_qna();
    }
    
    function dsp_all_qna(){
        $this->view->template->title = $this->view->course_name;
        $this->view->template->breadcrumbs = array();
        $this->view->arr_qna = $this->model->qry_all_qna();
        $this->view->render('qna/dsp_all_qna');
    }
    
    function dsp_single_qna($v_qna_id){
        $this->view->template->breadcrumbs[$this->view->course_name] = null;
        $this->view->template->title = $this->view->course_name;
    }
}

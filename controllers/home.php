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
class Home extends Controller {

    public function __construct() {
        parent::__construct('home');
        //$this->view->template->navbar = array('1' => array('1' => array('1'=>'1')));
        //$this->view->template->sidebar = array();
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
        $this->view->template->header = 'Trang chủ';
        $this->view->template->breadcrumbs = array();
    }

    function Index() {
        $this->view->arr_hot_vocab = $this->model->qry_hot_vocab();
        $this->view->arr_hot_grammar = $this->model->qry_hot_grammar();
        $this->view->arr_hot_kanji = $this->model->qry_hot_kanji();
        $this->view->arr_hot_qna = $this->model->qry_hot_qna();
        $this->view->arr_hot_document = $this->model->qry_hot_document();
        $this->view->render('home/index');
    }

}

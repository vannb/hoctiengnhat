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
    }

    function index()
    {
        $this->dsp_all_qna();
    }

    function dsp_all_qna()
    {
        $this->view->template->breadcrumbs = array(
            translate('Hỏi đáp') => null
        );
        $this->view->count_all_qna = $this->model->count_all_qna();
        $this->view->arr_all_qna = $this->model->qry_all_qna();
        $this->view->render('qna/dsp_all_qna');
    }

    function delete_qna($v_qna_id)
    {
        if (!about_user::is_admin())
        {
            return;
        }
        $this->model->delete_qna($v_qna_id);
        header('location: ' . $this->view->get_controller_url());
    }

    function dsp_single_qna($v_qna_id = 0)
    {
        $this->view->v_qna_id = $v_qna_id;
        if ($v_qna_id)
        {
            $this->view->template->breadcrumbs = array(
                translate('Hỏi đáp') => $this->view->get_controller_url(),
                translate('Xem hỏi đáp') => null
            );
            $this->view->arr_qna = $this->model->qry_single_qna($v_qna_id);
            if ($this->view->arr_qna)
            {
                $this->view->template->header = translate('Hỏi đáp');
                $this->view->template->title = translate('Hỏi đáp');
                $this->view->arr_answer = $this->model->qry_answer($v_qna_id);
            }
        } else
        {
            $this->view->template->breadcrumbs = array(
                translate('Hỏi đáp') => $this->view->get_controller_url(),
                translate('Gửi câu hỏi') => null
            );
        }
        $this->view->render('qna/dsp_single_qna');
    }

    function add_qna()
    {
        about_user::require_login();
        $qna_id = get_post_var('hdn_qna_id', 0);
        $result = $this->model->add_qna();
        if ($qna_id == 0)
        {
            $qna_id = $result;
        }
        redirect_popup_msg($this->view->get_controller_url() . 'dsp_single_qna/' . $qna_id, translate('Bài của bạn đã được gửi'));
    }

    function xhr_vote()
    {
        header('Content-Type: application/json');
        if (!about_user::is_login())
        {
            echo '-1';
        } else
        {
            echo json_encode($this->model->vote_qna());
        }
    }

}

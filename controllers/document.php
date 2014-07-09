<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Document extends Controller
{

    function __construct()
    {
        parent::__construct('document');
        $this->view->template->title = translate('Tài liệu');
        $this->view->template->header = translate('Tài liệu');
        $this->view->template->breadcrumbs = array('Tài liệu' => null);
        $this->view->template->show_sidebar = 1;
        $this->view->template->show_toggle_sidebar = 1;
    }

    function index()
    {
        $this->dsp_all_document();
    }

    function dsp_all_document()
    {
        $this->view->arr_all_document = $this->model->qry_all_document();
        $this->view->count_all_document = $this->model->count_all_document();
        var_dump($this->view->count_all_document);
        $this->view->render('document/dsp_all_document');
    }

    function upload_document()
    {
        about_user::require_login();
        $this->model->upload_document();
        header('location: ' . $this->view->get_controller_url() . 'dsp_all_document');
        
    }

    function download_document($v_document_id)
    {
        $document = $this->model->qry_single_document($v_document_id);
        $v_server_path = 'document/' . $document['C_SERVER_FILE_NAME'];
        if (file_exists($v_server_path))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($document['C_NAME'] . '.' . $document['C_EXT']));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($v_server_path));
            ob_clean();
            flush();
            readfile($v_server_path);
        }
    }

    function xhr_rate_document()
    {
        $document_id = get_post_var('document_id');
        $rating = floor(get_post_var('rating'));
        if (!about_user::is_login())
        {
            echo '-1';
            return;
        }
        if ($rating > 5 or $rating < 1)
        {
            echo '0';
            return;
        }
        echo $this->model->rate_document(about_user::current_user()->user_id, $document_id, $rating);
        return;
    }

    function set_document_shown($v_document_id)
    {
        if (!about_user::is_admin())
        {
            return;
        }
        $this->model->set_document_shown($v_document_id);
        header('location: ' . $this->view->get_controller_url() . 'dsp_all_document');
    }
    function delete_document($v_document_id)
    {
        if (!about_user::is_admin())
        {
            return;
        }
        $this->model->delete_document($v_document_id);
        header('location: ' . $this->view->get_controller_url() . 'dsp_all_document');
    }

}

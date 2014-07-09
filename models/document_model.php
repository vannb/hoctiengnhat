<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of document_model
 *
 * @author Loving
 */
class document_model extends Model
{

    function set_document_shown($v_document_id)
    {
        return DB::update('t_document', array('C_SHOWN' => 1), 'PK_DOCUMENT = ?', array($v_document_id));
    }

    function delete_document($v_document_id)
    {
        DB::delete('t_document', 'PK_DOCUMENT = ?', array($v_document_id));
    }

    function qry_all_document()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $record_per_page = DEFAULT_ROWS_PER_PAGE;
        $offset = ($page - 1) * $record_per_page;
        $db = DB::get_instance();
        $sql = "SELECT do.*, AVG(ra.C_RATING) AS AVG_RATING"
                . ", COUNT(ra.FK_USER) AS COUNT_RATED_USER"
                . ", us.C_NAME as C_UPLOADER_NAME"
                . " FROM t_document do"
                . " LEFT JOIN t_user us ON do.FK_UPLOADER = us.PK_USER"
                . " LEFT JOIN t_document_rating ra ON ra.FK_DOCUMENT = do.PK_DOCUMENT";
        if (!about_user::is_admin())
        {
            $sql.= " WHERE C_SHOWN = 1";
        }
        $sql.= " GROUP BY do.PK_DOCUMENT"
                . " ORDER BY do.C_SHOWN ASC, do.C_UPLOAD_DATE DESC"
                . " LIMIT ? OFFSET ?";
        return $db->GetAll($sql, array(
                    $record_per_page,
                    $offset
        ));
    }

    function count_all_document()
    {
        return DB::count('t_document');
    }

    function qry_single_document($v_document_id)
    {
        $result = DB::search('t_document', array(), array('PK_DOCUMENT' => $v_document_id));
        return $result[0];
    }

    function rate_document($user_id, $document_id, $rating)
    {
        $db = DB::get_instance();
        $db->Execute("REPLACE INTO t_document_rating(FK_USER,FK_DOCUMENT,C_RATING) values(?,?,?)", array($user_id, $document_id, $rating));
        return 1;
    }

    function upload_document()
    {
        //Upload file
        $count = count($_FILES['uploader']['name']);
        var_dump($_FILES);
        if ($_FILES['uploader']['error'] == 0)
        {
            $v_file_name = $_FILES['uploader']['name'];
            $v_document_name = get_post_var('name');
            $v_file_ext = array_pop(explode('.', $v_file_name));
            $v_tmp_name = $_FILES['uploader']['tmp_name'];
            $v_system_file_name = uniqid();
            if (move_uploaded_file($v_tmp_name, "document/" . $v_system_file_name))
            {
                $stmt = 'INSERT INTO t_document(C_NAME, C_EXT, C_SERVER_FILE_NAME,C_UPLOAD_DATE,C_SHOWN,FK_UPLOADER)'
                        . ' Values(?,?,?,NOW(),0,?)';
                $params = array($v_document_name, $v_file_ext, $v_system_file_name, about_user::current_user()->user_id);
                $db = DB::get_instance();
                $db->Execute($stmt, $params);
            }
        }
    }

}

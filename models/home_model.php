<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Home_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function qry_hot_vocab()
    {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : 0;
        $db = DB::get_instance();
        return $db->GetAll("SELECT vo.*"
                        . ",st1.PK_STARRED AS PK_STARRED"
                        . ", COUNT(st.PK_STARRED) AS STARRED"
                        . " FROM t_vocabulary vo"
                        . " LEFT JOIN t_starred_vocabulary st"
                        . " ON vo.PK_VOCABULARY = st.FK_VOCABULARY"
                        . " LEFT JOIN (SELECT * FROM t_starred_vocabulary WHERE FK_USER = ?) st1"
                        . " ON st1.FK_VOCABULARY = vo.PK_VOCABULARY"
                        . " GROUP BY PK_VOCABULARY"
                        . " ORDER BY STARRED DESC"
                        . " LIMIT 4;", array($user_id));
    }

    function qry_hot_grammar()
    {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : 0;
        $db = DB::get_instance();
        return $db->GetAll("SELECT gr.*"
                        . ",st1.PK_STARRED AS PK_STARRED"
                        . ", COUNT(st.PK_STARRED) AS STARRED"
                        . " FROM t_grammar gr"
                        . " LEFT JOIN t_starred_grammar st"
                        . " ON gr.PK_GRAMMAR = st.FK_GRAMMAR"
                        . " LEFT JOIN (SELECT * FROM t_starred_grammar WHERE FK_USER = ?) st1"
                        . " ON st1.FK_GRAMMAR = gr.PK_GRAMMAR"
                        . " GROUP BY PK_GRAMMAR"
                        . " ORDER BY STARRED DESC"
                        . " LIMIT 4;", array($user_id));
    }

    function qry_hot_kanji()
    {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : 0;
        $db = DB::get_instance();
        return $db->GetAll("SELECT ka.*"
                        . ",st1.PK_STARRED AS PK_STARRED"
                        . ", COUNT(st.PK_STARRED) AS STARRED"
                        . " FROM t_kanji ka"
                        . " LEFT JOIN t_starred_kanji st"
                        . " ON ka.PK_KANJI = st.FK_KANJI"
                        . " LEFT JOIN (SELECT * FROM t_starred_kanji WHERE FK_USER = ?) st1"
                        . " ON st1.FK_KANJI = ka.PK_KANJI"
                        . " GROUP BY PK_KANJI"
                        . " ORDER BY STARRED DESC"
                . " LIMIT 4;", array($user_id));
    }

    function qry_new_document()
    {
        $db = DB::get_instance();
        return $db->GetAll("SELECT do.*, AVG(ra.C_RATING) AS AVG_RATING"
                        . ", COUNT(ra.FK_USER) AS COUNT_RATED_USER"
                        . ", us.C_NAME as C_UPLOADER_NAME"
                        . " FROM t_document do"
                        . " LEFT JOIN t_user us ON do.FK_UPLOADER = us.PK_USER"
                        . " LEFT JOIN t_document_rating ra ON ra.FK_DOCUMENT = do.PK_DOCUMENT"
                        . " WHERE C_SHOWN = 1"
                        . " GROUP BY do.PK_DOCUMENT"
                        . " ORDER BY do.C_UPLOAD_DATE DESC"
                        . " LIMIT 4");
    }

    function qry_new_qna()
    {
        $db = DB::get_instance();
        $question = $db->GetRow("SELECT qna.*,SUM(C_VOTED) AS VOTED"
                . " FROM t_qna qna LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " WHERE qna.FK_QNA = 0"
                . " ORDER BY C_DATE_TIME DESC"
                . " LIMIT 4");
        if (!$question)
        {
            return array();
        }
        return $question;
    }

}

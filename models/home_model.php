<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class Home_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    function qry_hot_vocab(){
        $db = DB::get_instance();
        return $db->GetAll("SELECT vo.*, COUNT(PK_STARRED) AS STARRED"
                . " FROM t_vocabulary vo LEFT JOIN t_starred_vocabulary st"
                . " ON vo.PK_VOCABULARY = st.FK_VOCABULARY"
                . " GROUP BY PK_VOCABULARY"
                . " ORDER BY STARRED DESC LIMIT 5;");
    }
    function qry_hot_grammar(){
        $db = DB::get_instance();
        return $db->GetAll("SELECT gr.*, COUNT(PK_STARRED) AS STARRED"
                . " FROM t_grammar gr LEFT JOIN t_starred_grammar st"
                . " ON vo.PK_GRAMMAR = st.FK_GRAMMAR"
                . " GROUP BY PK_GRAMMAR"
                . " ORDER BY STARRED DESC LIMIT 5;");
        
    }
    function qry_hot_kanji(){
        $db = DB::get_instance();
        return $db->GetAll("SELECT ka.*, COUNT(PK_STARRED) AS STARRED"
                . " FROM t_kanji vo LEFT JOIN t_starred_kanji st"
                . " ON vo.PK_KANJI = st.FK_KANJI"
                . " GROUP BY PK_KANJI"
                . " ORDER BY STARRED DESC LIMIT 5;");
    }
    function qry_new_document(){
        $db = DB::get_instance();
        return $db->GetAll("SELECT do.*, AVG(ra.C_RATING) AS AVG_RATING"
                        . ", COUNT(ra.FK_USER) AS COUNT_RATED_USER"
                        . ", us.C_NAME as C_UPLOADER_NAME"
                        . " FROM t_document do"
                        . " LEFT JOIN t_user us ON do.FK_UPLOADER = us.PK_USER"
                        . " LEFT JOIN t_document_rating ra ON ra.FK_DOCUMENT = do.PK_DOCUMENT"
                        . " GROUP BY do.PK_DOCUMENT"
                        . " ORDER BY do.C_SHOWN ASC, do.C_UPLOAD_DATE DESC"
                        . " LIMIT ? OFFSET ?");
    }
    function qry_new_qna(){
        
    }
}

<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class Qna_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    function qry_all_qna(){
        $db = DB::get_instance();
        $sql = "SELECT qna.*"
                . ",us.C_NAME"
                . ",COUNT(vo.FK_QNA)"
                . ", SUM(C_VOTED)"
                . " FROM t_qna qna"
                . " JOIN t_user us"
                . " ON qna.FK_USER = us.PK_USER"
                . " LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " GROUP BY PK_QNA";
        echo $sql;
    }
    
    function qry_single_qna(){
        
    }
}
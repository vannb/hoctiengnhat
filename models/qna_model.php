<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Qna_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function vote_qna()
    {
        $qna_id = get_post_var('qna_id');
        $vote = get_post_var('vote');
        $user_id = about_user::current_user()->user_id;
        $result = DB::search('t_voted_qna', array(), array(
                    'FK_USER' => $user_id,
                    'FK_QNA' => $qna_id
        ));
        if ($result)
        {
            DB::delete('t_voted_qna', 'FK_USER = ? AND FK_QNA = ?', array($user_id, $qna_id));
        }
        DB::insert('t_voted_qna', array(
            'FK_USER' => $user_id,
            'FK_QNA' => $qna_id,
            'C_VOTED' => $vote
        ));
        $db = DB::get_instance();
        $arr_qna = $db->GetRow("SELECT qna.PK_QNA"
                . " ,SUM(vo.C_VOTED) SUM_VOTE"
                . " ,COUNT(vo.FK_QNA) COUNT_VOTE"
                . " FROM t_qna qna"
                . " LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " WHERE qna.PK_QNA = ?", array($qna_id));
        $count_up = ($arr_qna['COUNT_VOTE'] + $arr_qna['SUM_VOTE']) / 2;
        $count_down = ($arr_qna['COUNT_VOTE'] - $arr_qna['SUM_VOTE']) / 2;
        return array('up' => $count_up, 'down' => $count_down);
    }

    function qry_all_qna()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $record_per_page = DEFAULT_ROWS_PER_PAGE;
        $offset = ($page - 1) * $record_per_page;
        $db = DB::get_instance();
        $sql = "SELECT qna.*"
                . ",COUNT(DISTINCT qna1.PK_QNA)"
                . " AS COUNT_ANSWER"
                . " ,SUM(vo.C_VOTED) SUM_VOTE"
                . " ,COUNT(vo.FK_QNA) COUNT_VOTE"
                . " ,us.C_NAME AS C_NAME"
                . " FROM t_qna qna"
                . " LEFT JOIN t_qna qna1"
                . " ON qna1.FK_QNA = qna.PK_QNA "
                . " LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " LEFT JOIN t_user us"
                . " ON qna.FK_USER = us.PK_USER"
                . " WHERE qna.FK_QNA = 0"
                . " GROUP BY qna.PK_QNA"
                . " LIMIT ? OFFSET ?;";
        return $db->GetAll($sql,array($record_per_page,$offset));
    }

    function qry_single_qna($qna_id)
    {
        $db = DB::get_instance();
        $arr_qna = $db->GetAll("SELECT qna.*"
                . ",COUNT(qna1.PK_QNA) AS COUNT_ANSWER"
                . " ,SUM(vo.C_VOTED) SUM_VOTE"
                . " ,COUNT(vo.FK_QNA) COUNT_VOTE"
                . " ,us.C_NAME AS C_NAME"
                . " FROM t_qna qna"
                . " LEFT JOIN t_qna qna1"
                . " ON qna1.PK_QNA = qna.FK_QNA "
                . " LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " LEFT JOIN t_user us"
                . " ON qna.FK_USER = us.PK_USER"
                . " WHERE qna.PK_QNA = ?", array($qna_id));
        if (!$arr_qna)
            return array();
        return $arr_qna[0];
    }

    function qry_answer($qna_id)
    {
        $db = DB::get_instance();
        $arr_answer = $db->GetAll("SELECT qna.*"
                . " ,SUM(vo.C_VOTED) SUM_VOTE"
                . " ,COUNT(vo.FK_QNA) COUNT_VOTE"
                . " ,us.C_NAME AS C_NAME"
                . " FROM t_qna qna"
                . " LEFT JOIN t_voted_qna vo"
                . " ON qna.PK_QNA = vo.FK_QNA"
                . " LEFT JOIN t_user us"
                . " ON qna.FK_USER = us.PK_USER"
                . " WHERE qna.FK_QNA = ? "
                . " GROUP BY qna.PK_QNA"
                . " ORDER BY SUM_VOTE DESC", array($qna_id));
        return $arr_answer;
    }

    function add_qna()
    {
        $qna_id = get_post_var('hdn_qna_id', 0);
        $txt_title = get_post_var('txt_title', 0);
        $txt_content = get_post_var('txt_content', 0);
        $db = DB::get_instance();
        $db->Execute("INSERT INTO t_qna(FK_QNA,FK_USER,C_TITLE,C_CONTENT,C_DATE_TIME) values(?,?,?,?,NOW())"
                , array($qna_id, about_user::current_user()->user_id, $txt_title, $txt_content));
        return $db->Insert_ID();
    }

    function count_all_qna()
    {
        return DB::count('t_qna', array(), array('FK_QNA' => 0));
    }
}

<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class grammar_Model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function qry_all_starred_grammar()
    {
        return DB::search('t_grammar gr LEFT JOIN t_starred_grammar st'
                        . ' ON gr.PK_GRAMMAR = st.FK_GRAMMAR', array(), array('FK_USER' => about_user::current_user()->user_id));
    }

    function qry_lesson_grammar($lesson_id)
    {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : null;

        $db = DB::get_instance();
        $sql = "SELECT * FROM (SELECT * FROM t_grammar WHERE FK_LESSON = ?) gr"
                . " LEFT JOIN ( SELECT * FROM t_starred_grammar WHERE FK_USER = ?) st"
                . " ON st.FK_GRAMMAR = gr.PK_GRAMMAR ORDER BY FK_USER DESC;";
        $result = $db->GetAll($sql, array($lesson_id, $user_id));
        return $result;
    }

    function toggle_star()
    {
        $grammar_id = get_post_var('grammar_id');
        $user_id = about_user::current_user()->user_id;
        $result = DB::search('t_starred_grammar', array(), array(
                    'FK_USER' => $user_id,
                    'FK_GRAMMAR' => $grammar_id
        ));
        if ($result)
        {
            DB::delete('t_starred_grammar', 'FK_USER = ? AND FK_GRAMMAR = ?', array($user_id, $grammar_id));
            return 0;
        } else
        {
            DB::insert('t_starred_grammar', array(
                'FK_USER' => $user_id,
                'FK_GRAMMAR' => $grammar_id
            ));
            return 1;
        }
    }

}

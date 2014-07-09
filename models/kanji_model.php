<?php

/**
 * Description of kanji_model
 *
 * @author Mons
 */
class kanji_model extends Model {
    function __construct() {
        parent::__construct();
    }
//    
//    function qry_lesson_kanji($lesson_id) {
//        $result = DB::search('t_kanji', array(), array('FK_KANJI_LESSON' => $lesson_id));
//        return $result;
//    }
    
    function qry_all_starred_kanji()
    {
        return DB::search('t_kanji ka LEFT JOIN t_starred_kanji st'
                        . ' ON ka.PK_KANJI = st.FK_KANJI', array(), array('FK_USER' => about_user::current_user()->user_id));
    }

    function qry_lesson_kanji($lesson_id)
    {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : null;

        $db = DB::get_instance();
        $sql = "SELECT * FROM (SELECT * FROM t_kanji WHERE FK_KANJI_LESSON = ?) ka"
                . " LEFT JOIN (SELECT * FROM t_starred_kanji WHERE FK_USER = ?) st"
                . " ON st.FK_KANJI = ka.PK_KANJI ORDER BY FK_USER DESC;";
        $result = $db->GetAll($sql, array($lesson_id, $user_id));
        return $result;
    }

    function toggle_star()
    {
        $kanji_id = get_post_var('kanji_id');
        $user_id = about_user::current_user()->user_id;
        $result = DB::search('t_starred_kanji', array(), array(
                    'FK_USER' => $user_id,
                    'FK_KANJI' => $kanji_id
        ));
        if ($result)
        {
            DB::delete('t_starred_kanji', 'FK_USER = ? AND FK_KANJI = ?', array($user_id, $kanji_id));
            return 0;
        } else
        {
            DB::insert('t_starred_kanji', array(
                'FK_USER' => $user_id,
                'FK_KANJI' => $kanji_id
            ));
            return 1;
        }
    }

}

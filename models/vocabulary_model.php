<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class vocabulary_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function qry_lesson_vocabulary($lesson_id) {
        $user_id = (about_user::is_login()) ? about_user::current_user()->user_id : null;

        $db = DB::get_instance();
        $sql = "SELECT * FROM (SELECT * FROM t_vocabulary WHERE FK_LESSON = ?) vo"
                . " LEFT JOIN ( SELECT * FROM t_starred_vocabulary WHERE FK_USER = ?) st"
                . " ON st.FK_VOCABULARY = vo.PK_VOCABULARY ORDER BY FK_USER DESC;";

        $result = $db->GetAll($sql, array($lesson_id, $user_id));
        return $result;
    }

    function qry_all_starred_vocabulary() {
        return DB::search('t_vocabulary vo LEFT JOIN t_starred_vocabulary st'
                        . ' ON vo.PK_VOCABULARY = st.FK_VOCABULARY', array(), array('FK_USER' => about_user::current_user()->user_id));
    }

    function toggle_star() {
        $vocab_id = get_post_var('vocabulary_id');
        $user_id = about_user::current_user()->user_id;
        $result = DB::search('t_starred_vocabulary', array(), array(
                    'FK_USER' => $user_id,
                    'FK_VOCABULARY' => $vocab_id
        ));
        if ($result) {
            DB::delete('t_starred_vocabulary', 'FK_USER = ? AND FK_VOCABULARY = ?', array($user_id, $vocab_id));
            return 0;
        } else {
            DB::insert('t_starred_vocabulary', array(
                'FK_USER' => $user_id,
                'FK_VOCABULARY' => $vocab_id
            ));
            return 1;
        }
    }

}

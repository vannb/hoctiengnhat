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
    
    function qry_all_kanji_by_lesson($lesson_id) {
        $result = DB::search('t_kanji', array(), array('FK_KANJI_LESSON' => $lesson_id));
        return $result;
    }
}

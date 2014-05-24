<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class grammar_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function qry_lesson_grammar($lesson_id) {
        $result = DB::search('t_grammar', array(), array('FK_LESSON' => $lesson_id));
        return $result;
    }

}

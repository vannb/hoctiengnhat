<?php

class Categories_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function search($categoryName = '') {
        if ($categoryName == '')
            return $this->db->search('categories');
        else
            return $this->db->search('categories', array("categoryname" => $categoryName));
    }

    function Add($categoryName) {
        $categoryarr = array(
            'CategoryName' => $categoryName
        );
        return $this->db->insert('categories', $categoryarr);
    }

    function Edit($categoryid, $categoryname) {
        $result = $this->db->update('categories', array('CategoryName' => $categoryname), array('CategoryID' => $categoryid));
        return $result;
    }

    function categoryByID($categoryID) {
        $result = $this->db->search('categories',array(), array("categoryid" => $categoryID));
        return $result[0];
    }

}

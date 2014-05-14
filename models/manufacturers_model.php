<?php

class Manufacturers_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function search($manufacturerName = '') {
        if ($manufacturerName == '')
            return $this->db->search('manufacturers');
        else
            return $this->db->search('manufacturers', array("manufacturername" => $manufacturerName));
    }

    function Add($manufacturerName) {
        $manufacturerarr = array(
            'ManufacturerName' => $manufacturerName
        );
        return $this->db->insert('manufacturers', $manufacturerarr);
    }

    function Edit($manufacturerid, $manufacturername) {
        $result = $this->db->update('manufacturers', array('ManufacturerName' => $manufacturername), array('ManufacturerID' => $manufacturerid));
        return $result;
    }

    function manufacturerByID($manufacturerID) {
        $result = $this->db->search('manufacturers',0,array('manufacturerid' => $manufacturerID));
        return $result[0];
    }

}

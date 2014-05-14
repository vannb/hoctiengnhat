<?php

class Orders_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function search($offset = 0, $limit = 0) {
        return $this->db->search('orders',array(),array(), $offset, $limit);
    }

    function SetPurchased($orderID) {
        $updatearr = array('Purchased' => '1');
        $this->db->update('orders', $updatearr, array('orderID' => $orderID));
    }

    function SetNotPurchased($orderID) {
        $updatearr = array('Purchased' => '0');
        $this->db->update('orders', $updatearr, array('orderID' => $orderID));
    }

    function SetDelivered($orderID) {
        $updatearr = array('Delivered' => '1');
        $this->db->update('orders', $updatearr, array('orderID' => $orderID));
    }

    function SetNotDelivered($orderID) {
        $updatearr = array('Delivered' => '0');
        $this->db->update('orders', $updatearr, array('orderID' => $orderID));
    }

    function Count() {
        return $this->db->count('orders');
    }

}

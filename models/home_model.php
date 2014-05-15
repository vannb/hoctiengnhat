<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php
class Home_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function ProductByID($productID) {
        $result = $this->db->search('products join manufacturers using(manufacturerid)'
                . ' join categories using(CategoryID)'
                , 0, array("ProductID" => $productID));
        if (empty($result))
            return array();
        return $result[0];
    }

    function CategoryByID($categoryID) {
        $result = $this->db->search('categories'
                , 0, array("CategoryID" => $categoryID));
        if (empty($result))
            return array();
        return $result[0];
    }

    function ManufacturerByID($manufacturerID) {
        $result = $this->db->search('manufacturers'
                , 0, array("ManufacturerID" => $manufacturerID));
        if (empty($result))
            return array();
        return $result[0];
    }

    function SearchProducts($keyword = 0, $categoryid = 0, $manufacturerid = 0, $offset = 0, $limit = 0, $orderby = 0) {

        if ($keyword) {
            $keywordarr["ProductName"] = $keyword;
        } else {
            $keywordarr = array();
        }

        if ($categoryid) {
            $conditionarr['CategoryID'] = (int) $categoryid;
        } else {
            $conditionarr = array();
        }

        if ($manufacturerid) {
            $conditionarr['ManufacturerID'] = (int) $manufacturerid;
        }
        return $this->db->search('products join manufacturers'
                        . ' using(ManufacturerID)'
                        . ' join categories'
                        . ' using (CategoryID)'
                        , $keywordarr, $conditionarr, $offset, $limit, $orderby);
    }

    function SearchCategories() {
        return $this->db->search('categories');
    }

    function ProcessOrder($cart, $order) {
        $orderarr = array(
            'CustomerName' => $order['name'],
            'CustomerAddress' => $order['address'],
            'CustomerPhone' => $order['phone'],
            'Note' => $order['note'],
        );
        $orderid = $this->db->insert('orders', $orderarr);
        if ($orderid) {
            foreach ($cart as $productID => $info) {
                $order_productarr = array(
                    'OrderID' => $orderid,
                    'ProductID' => $productID,
                    'Quantity' => $info['quantity'],
                    'Price' => $info['price']
                );
                $this->db->insert('orders_products', $order_productarr);
            }
            $orderinfo = $this->db->search('orders', array(), array('orderID' => $orderid));
            $datetime = new DateTime($orderinfo[0]['OrderDateTime'], new DateTimeZone('Asia/Bangkok'));
            return array($orderid, $datetime);
        }
        return 0;
    }

    function CountProduct($keyword, $categoryid, $manufacturerid) {
        $condition = "ProductName LIKE '%" . $keyword
                . "%' AND products.manufacturerid = manufacturers.manufacturerid"
                . " AND products.categoryid = categories.categoryid";
        if ($categoryid) {
            $condition .= ' and categories.CategoryID = ' . $categoryid;
        }
        if ($manufacturerid) {
            $condition .= ' and manufacturers.manufacturerid=' . $manufacturerid;
        }
        $result = $this->db->count('products,categories,manufacturers', $condition);
        return $result;
    }

}

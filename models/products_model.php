<?php

class Products_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function ProductByID($ProductID = 0) {
        $result = $this->db->search('products join manufacturers using (manufacturerid)', array(), array('ProductID' => $ProductID));
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

    function Search($keyword = '', $pricefrom = 0, $priceto = 0, $categoryid = 0, $manufacturerid = 0, $offset = 0, $limit = 0, $orderby = 0) {
        $conditionarr = array();
        if ($pricefrom > 0) {
            $conditionarr['price>'] = $pricefrom;
        }
        if ($priceto > 0) {
            $conditionarr['price<'] = $priceto;
        }
        if ($categoryid > 0) {
            $conditionarr['categoryid'] = $categoryid;
        }
        if ($manufacturerid > 0) {
            $conditionarr['manufacturerid'] = $manufacturerid;
        }
        return $this->db->search('products join manufacturers'
                        . ' using (ManufacturerID)'
                        . ' join categories'
                        . ' using (CategoryID)'
                        , array('ProductName' => $keyword)
                        , $conditionarr
                        , $offset, $limit, $orderby);
    }

    function SearchManufacturer() {
        return $this->db->search('Manufacturers');
    }

    function SearchCategories() {
        return $this->db->search('Categories');
    }

    function UploadImages($productID, $images) {
        $imagespath = "views/images/products/" . $productID . '/';

        is_dir($imagespath) || mkdir($imagespath);

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $allowedTypes = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
        $numberOfImage = count($images['name']);
        for ($i = 0; $i < $numberOfImage; $i++) {
            $temp = explode(".", $images["name"][$i]);
            $extension = end($temp);

            if (!in_array(strtolower($images["type"][$i]), $allowedTypes) || !in_array(strtolower($extension), $allowedExts)) {
                require 'controllers/Error.php';
                new Error('Type of <em>"' . $images['name'][$i] . '"</em> is invalid');
                exit;
            }
        }
        for ($i = 0; $i < $numberOfImage; $i++) {
            if ($images["error"][$i] > 0) {
                echo "Return Code: " . $images["error"][$i] . "<br>";
                new Error("Return Code: " . $images["error"][$i] . "<br>");
                exit;
            }
        }
        for ($i = 0; $i < $numberOfImage; $i++) {

            echo "Upload: " . $images["name"][$i] . "<br>";
            echo "Type: " . $images["type"][$i] . "<br>";
            echo "Size: " . ($images["size"][$i] / 1024) . " kB<br>";
            echo "Temp file: " . $images["tmp_name"][$i] . "<br>";

            while (file_exists($imagespath . $images["name"][$i])) {
                $images["name"][$i] = 'Copy of ' . $images["name"][$i];
            }
            move_uploaded_file($images["tmp_name"][$i], $imagespath . $images["name"][$i]);
            chmod($imagespath . $images["name"][$i], 0777);
            echo "Stored in: " . $imagespath . $images["name"][$i] . '<br>';
        }
    }

    function Add($product, $images) {
        $result = $this->db->insert('products', $product);
        if (!($result > 0))
            return;

        if ($images['name'][0] != "") {
            Products_Model::UploadImages($result, $images);
        }

        return result;
    }

    function Edit($product, $images) {
        $result = $this->db->update('products', $product, array('productID' => $product['productid']));

        if ($images['name'][0] != "") {
            Products_Model::UploadImages($product['productid'], $images);
        }

        return $result;
    }

    function Delete($productID) {
        return $this->db->delete('products', array('ProductID' => $productID));
    }

    function DeleteMany($selected) {

        foreach ($selected as $productID) {
            Products_Model::Delete($productID);
        }
        return;
    }

    function Count($keyword = '',$pricefrom = 0,$priceto = 0, $categoryid = 0, $manufacturerid = 0) {
        $condition = "ProductName LIKE '%" . $keyword
                . "%'";
        if ($categoryid) {
            $condition .= ' and CategoryID = ' . $categoryid;
        }
        if ($manufacturerid) {
            $condition .= ' and manufacturerid=' . $manufacturerid;
        }
        if ($pricefrom) {
            $condition .= ' and price >=' . $pricefrom;
        }if ($priceto) {
            $condition .= ' and price <=' . $priceto;
        }
        $result = $this->db->count('products join categories'
                . ' using(categoryid)'
                . ' join manufacturers'
                . ' using(manufacturerid)', $condition);
        return $result;
    }

}

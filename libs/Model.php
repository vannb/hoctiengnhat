<?php if (!defined('SERVER_ROOT')) exit('No direct script access allowed'); ?>
<?php

class Model {

    public $db;

    function __construct() {
        $this->db = new DB();
    }

    public function is_mssql() {
        return DATABASE_TYPE == 'MSSQL';
    }

    public function is_mysql() {
        return DATABASE_TYPE == 'MYSQL';
    }

    public function is_oracle() {
        return DATABASE_TYPE == 'ORACLE';
    }

    public function getDate() {
        if (DATABASE_TYPE == 'MSSQL') {
            return $this->db->getOne("Select convert(varchar,getDate(), 120) as d");
        } elseif (DATABASE_TYPE == 'MYSQL') {
            return $this->db->getOne("Select Now() as d");
        }

        return NULL;
    }

    public function get_controller_url($name) {
        if (empty($name)) {
            $name = $this->name;
        }

        return URL . $name . '/';
    }

    public function last_inserted_id($table_name, $id_column_name = '') {
        if (DATABASE_TYPE == 'MSSQL') {
            return $this->db->getOne("SELECT IDENT_CURRENT('$table_name')");
        } elseif (DATABASE_TYPE == 'MYSQL') {
            return $this->db->Insert_ID($table_name, $id_column_name);
        }

        return NULL;
    }

}

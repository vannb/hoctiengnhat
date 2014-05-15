<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

require 'libs/adodb5/adodb.inc.php';

class DB {

    /**
     * @var \ADOConnection
     */
    public static $_instance;

    /** @var \string */
    public static $_cached_date;

    /**
     * @global string $ADODB_CACHE_DIR
     * @return \ADOConnection
     */
    public static function get_instance() {
        if (self::$_instance)
            return self::$_instance;

        switch (strtoupper(DB_TYPE)) {
            case 'ORACLE':
                //Oracle Setting
                putenv("NLS_LANG=AMERICAN_AMERICA.AL32UTF8");
                self::$_instance = NewADOConnection(CONST_ORACLE_DSN) or die('Cannot connect to Oracle Database Server!');
                break;

            case 'MYSQL':
                self::$_instance = ADONewConnection('mysqli://' . DB_USER . ':' . DB_PASS . '@' . DB_HOST . '/' . DB_NAME) or die('Cannot connect to MySQL Database Server!');
                //mysql_set_charset('utf8');
                self::$_instance->Execute("SET NAMES utf8");
                break;

            case 'MSSQL':
            default:
                self::$_instance = ADONewConnection('ado_mssql');
                self::$_instance->Connect(CONST_MSSQL_DSN) or die('Cannot connect to MSSQL Database Server!');
                break;
        }

        global $ADODB_CACHE_DIR;
        $ADODB_CACHE_DIR = SERVER_ROOT . 'cache/ADODB_cache/';

        self::$_instance->cacheSecs = 3600 * 24 * 7 * 4;
        self::$_instance->SetFetchMode(ADODB_FETCH_ASSOC);
        self::$_instance->debug = DEBUG_MODE;
        return self::$_instance;
    }

    public static function insert($table, $arr_data) {
        $db = static::get_instance();
        $count = count($arr_data);
        $sql = "Insert Into {$table}(" . implode(',', array_keys($arr_data)) . ")" .
                " Values(?" . str_repeat(',?', $count - 1) . ")";
        $db->Execute($sql, array_values($arr_data));
        if ($db->ErrorNo() == 0)
            return $db->Insert_ID($table);
        else
            return false;
    }

    public static function update($table, $arr_data, $conditions, $arr_cond_params = array()) {
        $db = static::get_instance();
        $sql = '';
        foreach ($arr_data as $k => $v) {
            if (!$sql) {
                $sql = "Update {$table} Set $k = ?";
            } else {
                $sql.= ", $k = ?";
            }
        }
        $sql .= " Where {$conditions}";
        $db->Execute($sql, array_merge(array_values($arr_data), $arr_cond_params));
        return $db->Affected_Rows();
    }

    public static function delete($table, $conditions = '1=0', $params = array()) {
        $db = static::get_instance();
        $sql = "Delete From {$table} Where $conditions";
        $db->Execute($sql, $params);
        return $db->Affected_Rows();
    }

    public static function get_date($get_cached = true) {
        $db = static::get_instance();
        if (!isset(self::$_cached_date) || $get_cached == false) {
            switch ($db->databaseType) {
                case 'mssql':
                    self::$_cached_date = $db->GetOne('Select GetDate()');
                    break;
                case 'mysql':
                case 'mysqli':
                    self::$_cached_date = $db->GetOne('Select Now()');
                    break;
            }
        }
        return self::$_cached_date;
    }

    public static function insert_many($table, $arr_data, $single_sql = true) {
        $arr_data = array_values($arr_data);
        if (!isset($arr_data[0]) || empty($arr_data[0])) {
            return;
        }
        if ($single_sql == false) {
            foreach ($arr_data as $row) {
                self::insert($table, $row);
            }
        } else {
            $db = self::get_instance();
            $sql = "Insert Into {$table}(" . implode(',', array_keys($arr_data[0])) . ") Values";
            $values = array();
            $params = array();
            $field_num = count($arr_data[0]);
            foreach ($arr_data as $row) {
                $values[] = "(?" . str_repeat(',?', $field_num - 1) . ")";
                $params = array_merge($params, array_values($row));
            }
            $sql .= implode(',', $values);
            $db->Execute($sql, $params);
        }
    }

    public static function search($tablename, $keywords = array(), $condition = array(), $offset = 0, $limit = 0, $orderby = 0) {
        $db = self::get_instance();
        $executearr = array();
        $sql = 'SELECT * FROM ' . $tablename . ' WHERE 1=1 ';
        if (!empty($keywords)) {
            foreach ($keywords as $key => $value) {
                $sql.=' AND ' . $key . ' LIKE "%?%"';
                $executearr[] = $value;
            }
        }

        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $key = trim($key);
                if (substr($key, -2) == '<=') {
                    $key = substr($key, 0, strlen($key) - 2);
                    $sql.= ' AND ' . $key . ' <= ?';
                    $executearr[] = $value;
                } elseif (substr(trim($key), -2) == '>=') {
                    $key = substr($key, 0, strlen($key) - 2);
                    $sql.= ' AND ' . $key . ' >= ?';
                    $executearr[] = $value;
                } else if (substr($key, -1) == '<') {
                    $key = substr($key, 0, strlen($key) - 1);
                    $sql.= ' AND ' . $key . ' < ?';
                    $executearr[] = $value;
                } elseif (substr(trim($key), -1) == '>') {

                    $key = substr($key, 0, strlen($key) - 1);
                    $sql.= ' AND ' . $key . ' > ?';
                    $executearr[] = $value;
                } else {
                    $sql.=' AND ' . $key . '= ?';
                    $executearr[] = $value;
                }
            }
        }

        if ($offset || $limit) {
            if ($limit) {
                $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            } else {
                $sql.= ' LIMIT ' . $limit;
            }
        }

        if ($orderby) {
            $sql .= ' ORDER BY ' . $orderby;
        }
        $sql.=';';
        if (!empty($executearr)) {
            $result = $db->GetAll($sql, $executearr);
        } else {
            $result = $db->GetAll($sql);
        }
        return $result;
    }

    public static function count($tablename, $keywords = array(), $condition = array()) {
        $db = self::get_instance();
        $executearr = array();
        $sql = 'SELECT * FROM ' . $tablename . ' WHERE 1=1 ';
        if (!empty($keywords)) {
            foreach ($keywords as $key => $value) {
                $sql.=' AND ' . $key . ' LIKE "%?%"';
                $executearr[] = $value;
            }
        }

        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $key = trim($key);
                if (substr($key, -2) == '<=') {
                    $key = substr($key, 0, strlen($key) - 2);
                    $sql.= ' AND ' . $key . ' <= ?';
                    $executearr[] = $value;
                } elseif (substr(trim($key), -2) == '>=') {
                    $key = substr($key, 0, strlen($key) - 2);
                    $sql.= ' AND ' . $key . ' >= ?';
                    $executearr[] = $value;
                } else if (substr($key, -1) == '<') {
                    $key = substr($key, 0, strlen($key) - 1);
                    $sql.= ' AND ' . $key . ' < ?';
                    $executearr[] = $value;
                } elseif (substr(trim($key), -1) == '>') {

                    $key = substr($key, 0, strlen($key) - 1);
                    $sql.= ' AND ' . $key . ' > ?';
                    $executearr[] = $value;
                } else {
                    $sql.=' AND ' . $key . '= ?';
                    $executearr[] = $value;
                }
            }
        }
        $sql.=';';
        if (!empty($executearr)) {
            $result = $db->GetAll($sql, $executearr);
        } else {
            $result = $db->GetAll($sql);
        }
        return $result;
    }

}

<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class Database extends PDO {

    function __construct($dbType = DB_TYPE, $dbHost = DB_HOST, $dbName = DB_NAME, $dbUser = DB_USER, $dbPass = DB_PASS) {
        parent::__construct($dbType . ':host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass);
    }

    function insert($tablename, $data) {
        //ex 'INSERT INTO users(colum1,colum2,colum3) values(:value1,:value2,:value3)'
        $executearr = array();
        foreach ($data as $key => $value) {
            $keyarr[] = $key;
            $placeholderarr[] = ':' . $key;
            $valuearr[] = $value;
            $executearr[':' . $key] = $value;
        }
        $keylist = implode(',', $keyarr);
        $placeholderlist = implode(',', $placeholderarr);
        $valuelist = implode(',', $valuearr);
        $sth = $this->prepare('INSERT INTO ' . $tablename . '(' . $keylist . ') values(' . $placeholderlist . ');');
//        echo 'INSERT INTO ' . $tablename . '(' . $keylist . ') values(' . $placeholderlist . ');';
//        echo '<pre>';
//        var_dump($executearr);
//        echo '</pre>';
        $sth->execute($executearr);
        $last = $this->lastInsertId();
        return $last;
    }

    function update($tablename, $data, $condition) {
        //ex 'UPDATE users SET colum1 = value1, colum 2 = value2 WHERE condition;
        foreach ($data as $key => $value) {
            $setarr[] = $key . ' = :new' . $key;
            $executearr[':new' . $key] = $value;
        }
        $setlist = implode(',', $setarr);

        foreach ($condition as $key => $value) {
            $conditionarr[] = $key . ' = :' . $key;
            $executearr[':' . $key] = $value;
        }

        $conditionlist = implode(' AND ', $conditionarr);
        $sth = $this->prepare('UPDATE ' . $tablename . ' SET ' . $setlist . ' WHERE ' . $conditionlist . ';');
//        echo 'UPDATE ' . $tablename . ' SET ' . $setlist . ' WHERE ' . $conditionlist . ';';
//        echo '<pre>';
//        var_dump($executearr);
//        echo '</pre>';
//        exit;
        return $sth->execute($executearr);
    }

    function delete($tablename, $condition) {
        //ex 'DELETE FROM users where id = 1;'
        foreach ($condition as $key => $value) {
            $conditionarr[] = $key . ' = :' . $key;
            $executearr[':' . $key] = $value;
        }

        $conditionlist = implode(' AND ', $conditionarr);

        $sth = $this->prepare('DELETE FROM ' . $tablename . ' WHERE ' . $conditionlist);
        //echo 'DELETE FROM ' . $tablename . ' WHERE ' . $conditionlist;
        return $sth->execute($executearr);
    }

    function search($tablename, $keywords = array(), $condition = array(), $offset = 0, $limit = 0, $orderby = 0) {
        //ex 'SELECT * FROM users where id = 1;'
        $conditionarr = array();
        $executearr = array();
        if (!empty($keywords)) {
            foreach ($keywords as $key => $value) {
                $conditionarr[] = $key . ' LIKE :' . $key;
                $executearr[':' . $key] = '%' . $value . '%';
            }
        }

        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $key = trim($key);
                if (substr($key, -1) == '<') {
                    $key = substr($key, 0, strlen($key) - 1);
                    $conditionarr[] = $key . ' <= :max' . $key;
                    $executearr[':max' . $key] = $value;
                } elseif (substr(trim($key), -1) == '>') {
                    $key = substr($key, 0, strlen($key) - 1);
                    $conditionarr[] = $key . ' >= :min' . $key;
                    $executearr[':min' . $key] = $value;
                } else {
                    $conditionarr[] = $key . ' = :' . $key;
                    $executearr[':' . $key] = $value;
                }
            }
        }

        if (!empty($conditionarr)) {
            $conditionlist = ' WHERE ' . implode(' AND ', $conditionarr);
        } else {
            $conditionlist = '';
        }

        if ($offset || $limit) {
            if ($limit) {
                $limitstr = ' LIMIT ' . $limit . ' OFFSET ' . $offset;
            } else {
                $limitstr = ' LIMIT ' . $limit;
            }
        } else
            $limitstr = '';

        $sth = $this->prepare('SELECT * FROM ' . $tablename . $conditionlist . $limitstr . ';');
        // echo 'SELECT * FROM ' . $tablename . $conditionlist . $limitstr . ';</br>';

        if (!empty($executearr)) {
            // var_dump($executearr);
            //exit;
            $sth->execute($executearr);
        } else {
            $sth->execute();
        }
        $result = $sth->fetchAll();
        return $result;
    }

    function count($tablename, $condition = '') {
        $statement = 'SELECT COUNT(*) FROM ' . $tablename;
        if ($condition != '') {
            $statement .= ' WHERE ' . $condition;
        }
        $sth = $this->prepare($statement);
        $sth->execute();
        $result = $sth->fetch();
        return $result[0];
    }

}

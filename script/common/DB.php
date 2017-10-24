<?php
class DB {

    private static $instance = null;
    private static $mysqli_instance = null;
    private $mysqli;

    final private function __construct(){}

    public static function getInstance($config = []){
        if (!self::$instance) {
            self::$instance = new self();
        }
        if (!$config) {
            $config['host'] = $_SERVER['SERVER_DB_HOST'];
            $config['user'] = $_SERVER['SERVER_DB_USER'];
            $config['pass'] = $_SERVER['SERVER_DB_PASS'];
            $config['dbname'] = $_SERVER['SERVER_DB_NAME'];
            $config['port'] = $_SERVER['SERVER_DB_PORT'];
        }
        if (!self::$mysqli_instance) {
            self::$instance->initMysqli($config);
        }
        return self::$instance;
    }

    private function initMysqli($config){
        $this->mysqli = new Mysqli();
        $this->mysqli->connect($config['host'], $config['user'], $config['pass'], $config['dbname'], $config['port']);
        if ($this->mysqli->connect_errno) {
            Log::log_message('error', "errno: ".$this->mysqli->connect_errno . ' errmsg: '.$this->mysqli->connect_error);
            return false;
        }
        self::$mysqli_instance = $this->mysqli;
        return true;
    }

    public function get_one($sql){
        if (!$this->mysqli) {
            return false;
        }
        $mysqli_result = $this->mysqli->query($sql);
        if (false === $mysqli_result) {
            $errmsg = 'mysql resource false,SQL:[ '.$sql.' ]';
            Log::log_message('error', $errmsg, 'ERROR');
            return false;
        }
        if ($mysqli_result && $mysqli_result->num_rows>0) {
            $data = $mysqli_result->fetch_assoc();
            return $data;
        } else {
            return [];
        }
    }


    public function get_all($sql){
        if (!$this->mysqli) {
            return false;
        }
        $mysqli_result = $this->mysqli->query($sql);
        if (false === $mysqli_result) {
            $errmsg = 'mysql resource false,SQL:[ '.$sql.' ]';
            Log::log_message('error', $errmsg, 'ERROR');
            return false;
        }
        if ($mysqli_result->num_rows > 0) {
            $data = $mysqli_result->fetch_all(MYSQLI_ASSOC);
            return $data;
        } else {
            return [];
        }
    }

    public function insert($sql){
        $mysqli_result = $this->mysqli->query($sql);
        if ($mysqli_result) {
            return $this->mysqli->insert_id;
        } else {
            return false;
        }
    }

    public function update($sql) {
        $mysqli_result = $this->mysqli->query($sql);
        if ($mysqli_result && $this->mysqli->affected_rows>0) {
            return true;
        } else {
            return false;
        }
    }

    public function transaction_exec($sqlArr){
        $this->mysqli->autocommit(false);
        $flag = true;
        foreach ($sqlArr as $sql) {
            $mysqli_result = $this->mysqli->query($sql);
            if ($mysqli_result && $this->mysqli->affected_rows>0) {
                $flag = $flag & true;
            } else {
                $flag = $flag & false;
            }
        }
        if ($flag) {
            $this->mysqli->commit();
            $this->mysqli->autocommit(true);
            return true;
        } else {
            $this->mysqli->rollback();
            $this->mysqli->autocommit(true);
            return false;
        }
    }

    private function __clone(){}





}




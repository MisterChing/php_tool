<?php
class RedisComm {

    private static $instance = null;
    private static $redisIns = null;
    private static $redisInsPool = [];
    private $redis;

    final private function __construct(){}

    public static function getInstance($config = []){
        if (!self::$instance) {
            self::$instance = new self();
        }
        if (!$config) {
            $config['host'] = $_SERVER['SERVER_REDIS_HOST'];
            $config['port'] = $_SERVER['SERVER_REDIS_PORT'];
        }
        $hashKey = md5(implode($config, ','));
        if (!self::$redisIns[$hashKey]) {
            self::$instance->initRedis($config);
        }
        return self::$instance;
    }

    private function initRedis($config){
        $this->redis = new Redis();
        $this->redis->pconnect($config['host'], $config['port']);
        $hashKey = md5(implode($config, ','));
        $this->redisInsPool[$hashKey] = $this->redis;
        return true;
    }

    public function __call($func, $args){
        $ret = call_user_func_array([$this->redis, $func], $args);
        return $ret;
    }


}


?>

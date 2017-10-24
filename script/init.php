<?php
error_reporting(E_ALL & ~E_NOTICE);
set_time_limit(0);
define('CODE_PATH', dirname(__FILE__));
date_default_timezone_set("Asia/Shanghai");
chdir(dirname(__FILE__));
$conf = getenv("CLI_CRON_CONF");
if ($conf) {
    $_SERVER = array_merge($_SERVER, parse_ini_file($conf));
}
class Local_loader {

    public static function autoLoad($className){
        $includePath = [
            CODE_PATH,
            CODE_PATH . '/common',
        ];
        foreach ($includePath as $k => $v) {
            if (file_exists($v . '/' . ucfirst($className) . '.php')) {
                require $v . '/' . ucfirst($className) . '.php';
                break;
            }
        }
    }
}
spl_autoload_register(['Local_Loader', 'autoLoad']);

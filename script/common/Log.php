<?php

class Log {

    public static function log_message($level, $str, $fileName = null){
        $str_prefix = strtoupper($level) . '-['.date('Y-m-d H:i:s').'] ';
        if ($fileName) {
            $fileSalt = $fileName;
        } else {
            $fileSalt = 'CLI';
        }
        $fileName = '../log/'. $fileSalt .'-' . date('Y-m-d') . '.log';
        $message = $str_prefix . $str . "\n";
        $fp = fopen($fileName, 'ab');
        flock($fp, LOCK_EX);
        for ($written = 0, $length = strlen($message); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($message, $written))) === false) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}


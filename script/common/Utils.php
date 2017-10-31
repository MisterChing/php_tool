<?php

class Utils {

    public static function isDate($dateStr, $formats = ['Ymd','Y-m-d']){
        $unixTime = strtotime($dateStr);
        if (!$unixTime) {
            return false;
        }
        foreach ($formats as $k => $v) {
            if (date($v, $unixTime) === $dateStr) {
                return true;
            }
        }
        return false;
    }

    public static function getNonceStr($length = 32){
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    public static function getRandomStr($length = 5, $chars = '0123456789'){
        if ($chars === 'chars') {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, $max)];
        }
        return $str;
    }

    public static function genPassword($password, $salt, $time, $upper = false){
        $superKey = 'ching';
        $str = hash('sha256', $superKey . $password . $salt . $time);
        $str = ($upper) ? strtoupper($str) : $str;
        return $str;
    }

    public static function genUUID($version = 3){
        switch ($version) {
            case 3:
                $hash = md5('aaa');
                return sprintf("%08s-%04s-%04s-%04s-%12s",
                    substr($hash, 0, 8),
                    substr($hash, 8, 4),
                    substr($hash, 12, 4),
                    substr($hash, 16, 4),
                    substr($hash, 20, 12)
                );
                break;
            default :
                break;
        }
    }


}




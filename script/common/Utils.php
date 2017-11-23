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
        $superKey = 'y0xh';
        $str = hash('sha256', $superKey . $password . $salt . $time);
        $str = ($upper) ? strtoupper($str) : $str;
        return $str;
    }


}




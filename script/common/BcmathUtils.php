<?php
/*
 * php7.3 以下
 * scale = 10 不额外不全后缀0 (除bcsqrt外)
 * scale 结果当作字符串处理 单纯截取位数 不作四舍五入
 */
class BcmathUtils {

    public static function add($left, $right, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcadd($left, $right, $scale);
        return $string;
    }

    public static function sub($left, $right, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcsub($left, $right, $scale);
        return $string;
    }

    public static function mul($left, $right, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcmul($left, $right, $scale);
        return $string;
    }

    public static function div($left, $right, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcdiv($left, $right, $scale);
        return $string;
    }

    public static function pow($base, $exponent, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcpow($base, $exponent, $scale);
        return $string;
    }

    public static function sqrt($base, $scale = 0){
        if (!extension_loaded('bcmath')) {
            throw new Exception("bcmath extension is not installed!");
        }
        $string = bcsqrt($base, $scale);
        return $string;
    }



}


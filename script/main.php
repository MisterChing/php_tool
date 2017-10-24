<?php
require 'init.php';
//计算时间 传时间计算某天的数据 不传默认计算前一天的数据 前闭后开

if ($argc > 1) {
    $cur_day = $argv[1];
    if (!preg_match("#\d{8}#Uis", $cur_day, $matches) || !Utils::isDate($argv[1])) {    //20170909
        $errmsg = "{$cur_day} 时间格式不正确!";
        Log::log_message('error', $errmsg, 'ERROR');
        exit($errmsg);
    }  
    if ($cur_day > date('Ymd')) {
        $errmsg = "{$cur_day} 大于当前日期!";
        Log::log_message('error', $errmsg, 'ERROR');
        exit($errmsg);
    }
    $startTime = strtotime($cur_day);
    $endTime = $startTime + 86400;
} else {
    $cur_day = date('Ymd', strtotime('-2 day'));
    $startTime = strtotime($cur_day);
    $endTime = $startTime + 86400;
}
$calc_day = $cur_day;   //参数计算的日期 time_day 的值


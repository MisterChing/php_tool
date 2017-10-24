<?php
require 'init.php';

if ($argc > 1) {
    $info['origin_pass'] = $argv[1];
    $info['salt'] = Utils::getRandomStr(5, 'chars');
    $info['time'] = time();
    $info['pass_word'] = Utils::genPassword($info['origin_pass'], $info['salt'], $info['time'], true);
    var_dump($info);

} else {
    die('参数错误');
}




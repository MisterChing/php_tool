<?php
require 'init.php';
// $base_url = "https://www.so.com/s?q=site%3Amp.weixin.qq.com+%E8%9E%8D%E5%88%9B&pn=1&src=srp_paging&fr=so.com";
$base_url = "https://www.so.com/s?q=site%3Amp.weixin.qq.com+%E8%9E%8D%E5%88%9B";

$total = [];
for ($i=1;$i<50;$i++) {
    $url = $base_url.'&pn='.$i.'&src=srp_paging&fr=so.com&adv_t=3m';
    $data = get_result($url);
    echo $i.PHP_EOL;
    $total = array_merge($total, $data);
}

$px = new PhpexcelComm();
$px->setOptions(['header'=>['标题','链接','简介'],'fileName'=>'3month']);
$px->save($total, CODE_PATH . '/../');

function get_result($url) {
    $base_url = $url;
    $html = file_get_contents($base_url);
    $result_regx = '#<ul class="result">(.*)</ul>#Uis';
    if (preg_match($result_regx, $html, $matches)) {
        $result = [];
        $result_html = $matches[1];
        $li_regx = '#<li class="res-list".*>(.*)</li>#Uis';
        if (preg_match_all($li_regx, $result_html, $li_matches)) {
            $li_html_arr = $li_matches[1];
            foreach ($li_html_arr as $per_html) {
                unset($item);
                $url_regx = '#<a href="(.*)".*>#Uis';
                preg_match($url_regx, $per_html, $url_matches);
                $url = $url_matches[1];
                $title_regx = '#<a.*>(.*)</a>#Uis';
                preg_match($title_regx, $per_html, $title_matches);
                $title = strip_tags($title_matches[1]);
                $des_regx = '#</span>(.*)<p class="res-linkinfo">#Uis';
                preg_match($des_regx, $per_html, $des_matches);
                $des = strip_tags($des_matches[1]);
                $item['title'] = $title;
                $item['url'] = $url;
                $item['des'] = $des;
                $result[] = $item;
            }
        }
    }
    return $result;

}

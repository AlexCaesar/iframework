<?php 
/**
 * @filename curl.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework 
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-25 04:23:48
 * @version $Id$ 
 */
class Curl {
    const _USERAGENT_   = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.5 Safari/537.22';
    const _REFERER_      = 'GoogleBot';
    public static function getContentsFromUrl($url){  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, 'http://' . $url);  
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_USERAGENT, self::_USERAGENT_);  
        curl_setopt($ch, CURLOPT_REFERER, self::_REFERER_);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        $r = curl_exec($ch);  
        curl_close($ch);  
        if(!$r || empty($r)){
            $f = new SaeFetchurl();
            $r = $f->fetch('http://' . $url);
        }
        return $r;  
    }  
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

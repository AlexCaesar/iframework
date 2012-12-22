<?php 
/**
 * @filename OOCore.php
 * @author T0ny<er@zhangabc.com>
 * @link  https://github.com/zhanger/iframework
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 18:46:35
 * @version $Id$ 
 */
class OOCore {
    private $_attributes;

    public function __set($name , $value){ 
        $_attributes[$name] = $value;
    }

    public function __get($name){
        if(isset($_attributes[$name]))
            return $_attributes[$name];
        else
            return '';
    }

    //TODO
    private function getConf($path){
    
    }
}

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
    public $_attributes;

    public function __set($name , $value){ 
        $this->_attributes[$name] = $value;
    }

    public function __get($name){
        if(isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        else
            return '';
    }

    //TODO
    private function getConf($path){
    
    }
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

<?php 
/**
 * @filename OOApp.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework 
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 18:45:21
 * @version $Id$ 
 */
class OOApp extends OOCore {
    public function __construct(){
        $this->config = OO::$config;
    }
    
    public function go(){
        $this->prepareRequest();
        //$this->init();
        $handler = ucwords(OO::$__appHandler) ."Handler";
        $this->$handler();
        $this->happyEnding();
    }

    private function getApp(){
    
    }

    private function prepareRequest(){
        $this->params = $_REQUEST;
    }

	protected function happyEnding(){
		OO::$log->handle();
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

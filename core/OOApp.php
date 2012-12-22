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
    private $_conf;
    private $_request;
    public  $db;
    
    public function __construct($conf){
        $this->_conf = $conf;
    }
    
    public function go(){
        $this->prepareRequest();
        $this->init();
        $handler = ucwords(OO::$__appHandler) ."Handler";
        $this->$handler();
    }

    private function getApp(){
    
    }

    private function prepareRequest(){
        $this->_request = $_REQUEST;
    }

    private function init(){
        
        $this->initDB();
    
    }
    private function initDB(){
        //TODO  ... getConf()
        if(!isset($this->_conf['apps'][strtolower(OO::$__appName)]['database']))
            return ;
        $dtype = $this->_conf['apps'][strtolower(OO::$__appName)]['database']['type'];
        $dconf = $this->_conf['apps'][strtolower(OO::$__appName)]['database']['conf'];

        if(!isset($this->_conf['database'][$dconf])){
            //TODO_LOG database conf error
            echo ' get database conf error';
            exit(0);
        }

        $db_conf = $this->_conf['database'][$dconf];
        $this->db = DB::getDB($db_conf);
    }

}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

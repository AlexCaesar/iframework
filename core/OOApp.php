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
    public $config;
    public $params;
    public $queue_type;
    public  $db;
    public function __construct($conf){
        $this->config = $conf;
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
        $this->params = $_REQUEST;
    }

    private function init(){
        
        $this->initDB();
    
    }
    private function initDB(){
        //TODO  ... getConf()
        if(!isset($this->config['apps'][strtolower(OO::$__appName)]['database']))
            return ;
        $dtype = $this->config['apps'][strtolower(OO::$__appName)]['database']['type'];
        $dconf = $this->config['apps'][strtolower(OO::$__appName)]['database']['conf'];

        if(!isset($this->config['database'][$dconf])){
            //TODO_LOG database conf error
            echo ' get database conf error';
            exit(0);
        }

        $dbconfig = $this->config['database'][$dconf];
        $this->db = DB::getDB($dbconfig);
		
		$this->queue_type = isset($this->config['apps'][strtolower(OO::$__appName)]['queue_type']) ?
			$this->config['apps'][strtolower(OO::$__appName)]['queue_type'] : 0 ;
    }

}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

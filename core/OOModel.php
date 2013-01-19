<?php 
/**
 * @filename OOModel.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework 
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-25 05:31:33
 * @version $Id$ 
 */
class OOModel extends OOCore {
    public function __construct(){
        $this->log			= OO::$log;
        $this->config		= OO::$config;
        $this->db_config	= OO::$db_server;
        $this->queue_type	= OO::$queue_type;
		$this->init();
		$this->queue		= new DBqueue($this->db, $this->queue_type, true);
    }

    private function init(){
        $this->initDB();
    }

    private function initDB(){
        $this->db = DB::getDB($this->db_config);
    }
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

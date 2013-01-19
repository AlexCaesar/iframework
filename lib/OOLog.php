<?php 
/**
 * @filename OOLog.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework 
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2013-01-20 01:01:53
 * @version $Id$ 
 */

class OOLog {
    const DEBUG = 2;
    const TRACE = 4;
    const ERROR = 8;

    private $log; 
    private $level; 

    public function __construct($level){
        $this->log = array();
        $this->level = ($level == intval($level)) ? intval($level) : 0;
    }

    private function log($level, $type, $string){
        $log_string =  date("Ymd H:i:s") 
            . "[{$type}] - "
            . strval($string);
        $this->log[] = array(
            'level'   => $level,
            'content' => $log_string
        ) ;
    }

    public function debug($string){ $this->log(self::DEBUG,'debug', $string); }
    public function trace($string){ $this->log(self::TRACE,'trace', $string); }
    public function error($string){ $this->log(self::ERROR,'error', $string); }


    //暂时全部输出到页面上去。。。
    public function handle(){
        if(empty($this->log) || $this->level < 1) return;
        echo "<pre style='background:#043945; color:#fff;letter-spacing: .11em;font-family: Consolas, Georgia, \"Times New Roman\", serif; font-weight: normal; font-size:1.1em; display: block; padding: 0.5em 1em; border: 1px solid #bebab0;'>";
        foreach($this->log as $log){
            if($this->level & $log['level']){
                echo $log['content'] . " \n";
            }
        }
        echo "</pre>";
    }
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

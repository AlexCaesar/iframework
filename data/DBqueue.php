<?php 
/**
 * @filename DBqueue.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-23 14:46:05
 * @version $Id$ 
 */

class DBqueue {

    public  $db;
    public  $unique;
    private $_type;
    private $_table;


    public function __construct($db, $type, $unique = true, $table_pre = ''){
        if(!$db) {
            //TODO_LOG 
            echo "init queue error: db error";
            exit(0);
        }
        $this->db     = $db;
        $this->_type  = $type;
        $this->_table = ($unique) ? $table_pre . "_oo_queue_un" : $table_pre . "_oo_queue";
        $check_sql    = "show tables like '{$this->_table}'";

        if($this->db->execute($check_sql) == 0){
            //TODO_LOG echo "init queue error: create table error";
            $this->createTable($unique);
        }
    }


    public function add($value, $times = 1){
        $sql = sprintf($this->_sql_insert, 
            $this->_table, 
            intval($this->_type), 
            $value,
            $times
        );
        $re = $this->db->execute($sql);
        return $re;
    }

    public function get($count = 1){
        //TOTO mysql transaction
        $return = array();
        $sql = sprintf($this->_sql_get_top, 
            $this->_table,
            intval($this->_type),
            intval($count)
        );
        $queue = $this->db->fetchAll($sql);
        foreach($queue as $item){
            $return[] = $item['value'];
            $this->db->execute(
                sprintf($this->_sql_update_times, 
                    $this->_table, $item['times']-1, $item['id']
                )
            );
        }

        return $return;
    }

    private function createTable($unique){
        $sql = ($unique) ? sprintf($this->_sql_create_table_unique, $this->_table) :
            sprintf($this->_sql_create_table, $this->_table);
        $this->db->execute($sql);
    }

    private $_sql_update_times = <<<SQL
update %s set times=%d where id=%d
SQL;

    private $_sql_get_top = <<<SQL
select * from  %s where `type`=%d and times>0 limit %d
SQL;

    private $_sql_insert = <<<SQL
insert into %s (`type`, value, times) values(%d, "%s" , %d)
SQL;

    private $_sql_create_table = <<<SQL
CREATE  TABLE `%s` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` TINYINT NOT NULL DEFAULT 0 ,
  `value` CHAR(255) NOT NULL ,
  `times` VARCHAR(45) NOT NULL DEFAULT 0 ,
  `createat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;
    private $_sql_create_table_unique = <<<SQL
CREATE TABLE `%s` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `type` tinyint(4) NOT NULL DEFAULT '0',
    `value` char(255) NOT NULL,
    `times` varchar(45) NOT NULL DEFAULT '0',
    `createat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `value_UNIQUE` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
SQL;

}

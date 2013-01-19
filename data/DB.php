<?php 
/**
 * @filename Db.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 18:34:54
 * @version $Id$ 
 */

class DB {
    public static function getDB($conf, $db_type='mysql'){

        if ('mysql' !== $db_type){
            //TODO_LOG mysql support only
            echo ' mysql support only';
            exit(0);
        }

        $db_class = 'DB'.ucwords($db_type);
        $db_object = new $db_class($conf);
        return $db_object;
    }
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

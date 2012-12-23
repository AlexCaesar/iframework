<?php 
/**
 * @filename DBMysql.php
 * @author T0ny<er@zhangabc.com>
 * @link https://github.com/zhanger/iframework
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 18:50:52
 * @version $Id$ 
 */
class DBMysql {

    public $_resource;
    public $_affectedRows;
    public $_lastInsID;

    public function __construct($dbconf){
        $host      = isset($dbconf['host'])    ? $dbconf['host'] : 'localhost';  
        $port      = isset($dbconf['port'])    ? $dbconf['port'] : 3306;  
        $user      = isset($dbconf['user'])    ? $dbconf['user'] : 'root';  
        $pwd       = isset($dbconf['pwd'] )    ? $dbconf['pwd']  : '';  
        $name      = isset($dbconf['name'])    ? $dbconf['name'] : '';  
        $charset   = isset($dbconf['charset']) ? $dbconf['charset'] : 'utf8';  
        $this->connect($host, $user, $pwd,  $port, $name, $charset );
    }

    public function connect($host, $username, $password,  $port=3306, $dbname='', $charset='utf8' ) {
        if (empty($this->_resource)) {
            $this->_resource = mysql_connect("{$host}:{$port}", $username,$password);
        }
        $select_db_error = ('' == $dbname) ? false :
            mysql_select_db($dbname, $this->_resource);

        if ( !$this->_resource ||  !$select_db_error ) {
            //TODO_LOG mysql connect error
            echo mysql_error();
            exit(0);
        }
        mysql_query("SET NAMES '{$charset}'", $this->_resource);
        return $this->_resource;
    }

    public function execute($sql) {
        if ( !$this->_resource ) 
            return false;
        $result = mysql_query($sql, $this->_resource) ;
        if ( false === $result) {
            //TOTO_LOG execute sql error
            return false;
        } else {
            $this->_affectedRows = mysql_affected_rows($this->_resource);
            $this->_lastInsID = mysql_insert_id($this->_resource);
            return $this->_affectedRows;
        }
    }

    public function fetchAll($sql) {
        $result = array();
        $query  = mysql_query($sql, $this->_resource);
        if(false == $query) {
            //TODO_LOG mysql query error
            echo mysql_error();
            return $result;
        }
        while($row = mysql_fetch_assoc($query)){
            $result[]   =   $row;
        }
        return $result;
    }

    public function close() {
        if ($this->_resource){
            mysql_close($this->_resource);
        }
        $this->_resource = null;
    }

    public function error() {
        $this->error = mysql_error($this->_resource);
        if('' != $this->queryStr){
            $this->error .= "\n [ SQL语句 ] : ".$this->queryStr;
        }
        trace($this->error,'','ERR');
        return $this->error;
    }

    public function free() {
        mysql_free_result($this->_resource);
    }

    public function getSafeString($str) {
        if($this->_resource) {
            return mysql_real_escape_string($str,$this->_resource);
        }else{
            return mysql_escape_string($str);
        }
    }
}

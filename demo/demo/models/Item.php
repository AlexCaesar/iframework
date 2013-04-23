<?php 
/**
 * @filename Article.php
 * @author T0ny<er@zhangabc.com>
 * @link http://www.zhangabc.com/
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-25 19:27:41
 * @version $Id$ 
 */

class Item extends OOModel {

	public function test(){
        $sql  = 'select xxx from xxx';

        //日志可以这样子
        $this->log->debug("debug xxxxxx");
        $this->log->trace("trace xxxxxx");
        $this->log->error("error xxxxxx");

        //数据库可以这样子操作
		$re   = $this->db->fetchAll($sql);

        $return = array();
		if(!is_array($re) || empty($re)) return $return;
        return $return;
	}
}

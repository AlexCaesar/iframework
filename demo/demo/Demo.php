<?php 
/**
 * @filename Demo.php
 * @desc  一个简单的Demo
 * @author T0ny<er@zhangabc.com>
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 01:05:50
 * @version $Id$ 
 */
class Demo extends OOApp{

	public function testHandler(){
		$id = isset($this->params['i']) ? intval($this->params['i']) : 0;
		$item  = new Item();
		$item->test();
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

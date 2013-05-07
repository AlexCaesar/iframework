<?php 
/**
 * @filename iconf.php
 * @desc 唯一的配置文件
 * @author T0ny<er@zhangabc.com>
 * @date 2012-12-22 01:02:20
 * @version $Id$ 
 */
return array(
    //应用基本路径
    'basePath' => dirname(__FILE__),
	//日志记录级别 2:debug  4:strace  8: error 
	//如果需要记录2种，数值进行求和即可。
	//如同时记录debug 与 error日志，设置为 10
	'log' => 14, 
	//输出压缩格式
	'zip' => 'gzip',

    //路径中注册的应用
    'apps'  => array(
        'demo' => array(
			//队列配置,全局唯一KEY
			'queue_type' => 'demo_key' ,  
            //数据库配置使用  database节点中的键值
            'database' => array(
                'type' => 'mysql',  
                'conf' => 'test',
            ),
        ),
    ),

    //数据库配置
    'database'    => array(
        'test' => array(
            'host'      => 'localhost',
            'port'      => 3306,
            'user'      => 'root',
            'pwd'       => 'hicc',
            'name'      => 'cnbeta',
            'charset'   => 'utf8',
        ), 
    ),
);

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */

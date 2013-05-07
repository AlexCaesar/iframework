<?php 
/**
 * OO框架主文件
 * 
 * @package 
 * @copyright @2012
 * @author Er Zhang<er@zhangabc.com> 
 * @link https://github.com/zhanger/iframework
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 * @version $id$
 */
defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
defined('OO_DEBUG') or define('OO_DEBUG',false);
class OO {
    public static $__appName;
    public static $__basePath;
    public static $__appHandler;
    public static $__appBasePath;
    public static $__includePaths;

	public static $db;
	public static $app;
	public static $log;
	public static $queue;
	public static $config;
	public static $db_server;
	public static $queue_type;

    public static function createApp($conf){
		self::$config = $conf;
		if(isset($conf['zip'])){
			self::preInitOutputBuffer($conf['zip']);
		}
        self::init();
        self::initDBConfig();
        Autoloader::Register();
		self::$app	 = new self::$__appName($conf);
		if(isset($conf['log'])){
			self::preInitLog($conf['log']);
		}
        return self::$app;
    }

	private static function preInitLog($level){
		$level = (empty($level) || intval($level) != $level) ? 0 : intval($level);
		self::$log = new OOLog($level);
	}
	private static function preInitOutputBuffer($type){
		if(strlen($type) < 1 ) return;
		if($type == 'gzip'){
			@ob_start ('ob_gzhandler');                                         
			header('Content-type: text/html; charset: UTF-8');                  
			header('Cache-Control: must-revalidate');                           
			header("Expires: " . gmdate('D, d M Y H:i:s', time() - 1) . ' GMT');
		}
	}

    private static function setIncludePaths(){
        self::$__includePaths = array_unique(explode(PATH_SEPARATOR , get_include_path()));
        self::$__includePaths[] = dirname(__FILE__) . '/core';
        self::$__includePaths[] = dirname(__FILE__) . '/data';
        self::$__includePaths[] = dirname(__FILE__) . '/lib';

        self::$__appBasePath = self::$__basePath . DIRECTORY_SEPARATOR . strtolower(self::$__appName);
        if(is_dir(self::$__appBasePath)){
            self::$__includePaths[] = self::$__appBasePath;
			if(is_dir(self::$__appBasePath . '/models'))
				self::$__includePaths[] = self::$__appBasePath . '/models';
			if(is_dir(self::$__appBasePath . '/controllers'))
				self::$__includePaths[] = self::$__appBasePath . '/controllers';
		}
    }

    private static function init(){
		$conf = self::$config ;
        $apps = array_keys($conf['apps']);
        self::$__appName  = isset($_REQUEST['app']) ? ucwords($_REQUEST['app']) : '_appdonothave';
		self::$queue_type = isset($conf['apps'][strtolower(OO::$__appName)]['queue_type']) ?
			$conf['apps'][strtolower(OO::$__appName)]['queue_type'] : 0 ;
        if(!isset($conf['basePath']) || 
            0 == strlen($conf['basePath']) ||
            !is_dir($conf['basePath'])
        ){
            //TODO_LOG fatal error
            echo 'app base path error';
            exit(0);
        }
        self::$__basePath   = $conf['basePath'];
        self::$__appHandler = isset($_REQUEST['handler']) ? $_REQUEST['handler'] : 'default';
        if(!in_array(strtolower(self::$__appName), $apps)){
            //TODO_LOG fatal error
            echo 'app or handler error';
            exit(0);
        }
        self::setIncludePaths();
    }


	private static function initDBConfig(){
		$conf = self::$config;
        if(!isset($conf['apps'][strtolower(OO::$__appName)]['database']))
            return ;
        $dtype = $conf['apps'][strtolower(OO::$__appName)]['database']['type'];
        $dconf = $conf['apps'][strtolower(OO::$__appName)]['database']['conf'];

        if(!isset($conf['database'][$dconf])){
            //TODO_LOG database conf error
            echo ' get database conf error';
            exit(0);
        }
		OO::$db_server = $conf['database'][$dconf];
	}
}

/**
 * @desc Autoloader
 * @author T0ny<er@zhangabc.com>
 * @link http://www.zhangabc.com/
 * @license http://www.zend.com/license/3_0.txt   PHP License 3.0
 * @date 2012-12-22 01:21:57
 * @version $Id$ 
 */
class Autoloader
{
    public static function Register(){
        return spl_autoload_register(
            array(
                __CLASS__,
                'loadController'
            )
        );
    }
    
    public static function loadController($className){
        set_include_path('.' . PATH_SEPARATOR . implode(PATH_SEPARATOR, array_unique(OO::$__includePaths)));
        if(!class_exists($className)){
            foreach(OO::$__includePaths as $path){
                $file_path = $path . DIRECTORY_SEPARATOR . $className . '.php';
                if(is_file($file_path))
                    include_once($file_path);
            }
        }
    }
}


/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
